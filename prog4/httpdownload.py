import socket
import sys
import argparse
parser = argparse.ArgumentParser()
parser.add_argument("--url")
parser.add_argument("--remotefile")
args = parser.parse_args()


def receive_all_data(s):
    data = []
    response = s.recv(4096)
    while (len(response) > 0):
        data.append(response)
        response = s.recv(4096)
    response = b''.join(data)
    return response


def get_domain(url):
    if url[0:8] == "https://":
        url = url.replace("https://", "")
    if url[0:7] == "http://":
        url = url.replace("http://", "")
    if url[-1] == '/':
        url = url.replace("/","") 
    return url 


client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
url = args.url
file = args.remotefile
domain = get_domain(url)
client.connect((domain, 80))
request = "GET "+file+" HTTP/1.1\r\n"+"Host: "+domain+"\r\n"+"\r\n"
client.send(request.encode())
response = receive_all_data(client)
len_image = b""
if b"HTTP/1.1 200 OK" in response:
    for i in range(0, len(response)):
        if len_image != b"":
            break
        if response[i:i+16] == b"Content-Length: ":
            for j in range(i+16, len(response)):
                if(not chr(response[j]).isdigit()):
                    len_image = response[i+16:j]
                    break
else:
    print("Khong ton tai file anh.")
    exit(0)
print("Kich thuoc file: "+len_image.decode()+" bytes")
content_file = response.split(b"\r\n\r\n")[1]
fileName = file.split('/')[-1]
location = "/tmp/"+fileName
open(location, "wb").write(content_file)