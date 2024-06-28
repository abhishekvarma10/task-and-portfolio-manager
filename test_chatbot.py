import requests
import json

url = 'http://localhost:5000/chat'
payload = {
    'message': 'Hello, chatbot!'
}
headers = {
    'Content-Type': 'application/json'
}

response = requests.post(url, json=payload, headers=headers)

if response.status_code == 200:
    print(response.json())
else:
    print(f"Request failed with status code {response.status_code}")
    print(response.text)
