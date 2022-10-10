import socket 
import sys
import argparse

parser = argparse.ArgumentParser()
parser.add_argument("--url")
parser.add_argument("--user")
parser.add_argument("--password")
args = parser.parse_args()

#get domain from url
def get_domain(url):
    if url[0:8] == "https://":
        url = url.replace("https://", "")
    if url[0:7] == "http://":
        url = url.replace("http://", "")
    if url[-1] == '/':
        url = url.replace("/","") 
    return url 

#Get data
def receive_all_data(data):
    all_data = []
    response = data.recv(4096)
    while (len(response)>0):
        all_data.append(response.decode())
        response = data.recv(4096)
    response = ''.join(all_data)
    return response 

url = args.url
user = args.user
password = args.password
domain = get_domain(url)
client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
client.connect((domain, 80))
body = "log="+user+"&pwd="+password+"&wp-submit=Log+In"
request = "POST /wp-login.php HTTP/1.1\r\n"
request += "Host: "+domain+"\r\n"
request += "Content-Type: application/x-www-form-urlencoded\r\n"
request += "Content-Length: " + str(len(body)) + "\r\n"
request += "Connection: close\r\n"
request += "\r\n" + body
# print(request)
client.send(request.encode())
response = receive_all_data(client)
# print(response)
if "ERROR" in response:
    print("User "+user+" dang nhap that bai")
else:
    print("User "+user+" dang nhap thanh cong")
