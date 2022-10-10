import socket 
import sys 
import argparse
import html

parser = argparse.ArgumentParser()
parser.add_argument("--url")
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
domain = get_domain(url)
client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
client.connect((domain, 80))
request = "GET / HTTP/1.1\r\nHOST: "+domain+"\r\n\r\n"
client.send(request.encode())
response = receive_all_data(client)

#Get title
title = ""
for i in range(0, len(response)):
    if title != "":
        break
    if response[i:i+7] == "<title>":
        # print("yes")
        for j in range(i+7, len(response)):
            if response[j:j+8] == "</title>":
                title = response[i+7:j]
                break
print("title:", html.unescape(title))
