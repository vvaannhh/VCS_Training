import socket
import sys
import string
import argparse
import re
parser = argparse.ArgumentParser()
parser.add_argument("--url")
parser.add_argument("--user")
parser.add_argument("--password")
parser.add_argument("--localfile")
args = parser.parse_args()


def receive_all_data(s):
    total_data = []
    response = s.recv(4096)
    while (len(response) > 0):
        total_data.append(response.decode())
        response = s.recv(4096)
    response = ''.join(total_data)
    return response


def get_domain(url):
    if url[0:8] == "https://":
        url = url.replace("https://", "")
    if url[0:7] == "http://":
        url = url.replace("http://", "")
    if url[-1] == '/':
        url = url.replace("/","") 
    return url 


def get_cookie(response):
    cookie = []
    stringSplit = response.split("\r\n")
    for i in stringSplit:
        if "Set-Cookie: " in i:
            cookie.append(i.split(";")[0].split(":")[1].strip())
    return ";".join(cookie)


def get_wpnonce(cookie, domain):
    client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    client.connect((domain, 80))
    request = "GET /wp-admin/media-new.php HTTP/1.1\r\n" + \
        "Host: "+domain+"\r\n"+"Cookie: "+cookie+"\r\n\r\n"
    client.send(request.encode())
    response = receive_all_data(client)
    start = re.search('name="_wpnonce"', response).end() + 8
    end = start + 10
    return response[start:end]
    return result


def upload(cookie, domain, fileName, localfile):
    data = open(localfile, 'rb').read()
    wpnonce = get_wpnonce(cookie, domain)
    contentType = fileName.split(".")[-1]
    client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    client.connect((domain, 80))
    body = "------WebKitFormBoundary"+"\r\n"+"Content-Disposition: form-data; name=\"name\"" + \
        "\r\n\r\n"+fileName+"\r\n"+"------WebKitFormBoundary"+"\r\n" + \
        "Content-Disposition: form-data; name=\"action\"" + \
        "\r\n\r\n"+"upload-attachment"+"\r\n"+"------WebKitFormBoundary"+"\r\n" + \
        "Content-Disposition: form-data; name=\"_wpnonce\""+"\r\n\r\n"+wpnonce+"\r\n"+"------WebKitFormBoundary" + \
        "\r\n"+"Content-Disposition: form-data; name=\"async-upload\"; filename=\"" + \
        fileName+"\""+"\r\n"+"Content-Type: image/"+contentType+"\r\n\r\n"
    body = body.encode()+data+b"\r\n"+b"------WebKitFormBoundary--"
    len_body = str(len(body))
    request = "POST /wp-admin/async-upload.php HTTP/1.1\r\n"+"Host: "+domain+"\r\n"+"Cookie: " + \
        cookie+"\r\n"+"Connection: keep-alive\r\n"+"Content-Type: multipart/form-data; boundary=----WebKitFormBoundary" + \
        "\r\n"+"Content-Length: "+len_body+"\r\n"+"\r\n"
    client.send(request.encode()+body)
    response = receive_all_data(client)
    if "HTTP/1.1 200 OK" in response and "{\"success\":true" in response:
        print("Upload success.")
        path_url = ""
        for i in range(0, len(response)):
            if(path_url != ""):
                break
            if response[i:i+7] == "\"url\":\"":
                for j in range(i+7, len(response)):
                    if(response[j] == "\""):
                        break
                    path_url += response[j]
        path_url = path_url.replace('\\', '')
        print("File upload url:"+path_url)
    else:
        print("Upload fail.")
    return


client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
url = args.url
username =args.user
password = args.password
localfile = args.localfile
domain = get_domain(url)
# print(domain)
fileName = localfile.split("/")[-1]
client.connect((domain, 80))
body = "log="+username+"&pwd="+password+"&wp-submit=Log+In"
request = "POST /wp-login.php HTTP/1.1\r\n"+"HOST: "+domain + "\r\n"+"Content-Length: "+str(len(body))+"\r\n"+"Content-Type: application/x-www-form-urlencoded"+"\r\n" \
    "\r\n"+body

client.send(request.encode())
response = receive_all_data(client)

if "HTTP/1.1 302 Found" in response:
    cookie = get_cookie(response)
    upload(cookie, domain, fileName, localfile)

else:
    print("User "+user+" dang nhap that bai.")
    exit()
