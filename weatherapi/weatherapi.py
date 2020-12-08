import json
import requests
import sys 


api_key = '055997a3efcd913f3ef01ff6b8eecd6a'
api_default_url =  'http://api.openweathermap.org/data/2.5/'
location = 'london'
country = 'uk'

headers = {'Content-Type': 'application/json',
           'Authorization': 'Bearer {0}'.format(api_key)}


def get_api_data():

    api_url = '{0}weather?q={1},{2}&appid={3}'.format(api_default_url,location,country,api_key)

    response = requests.get(api_url, headers=headers)

    if response.status_code == 200:
        return json.loads(response.content.decode('utf-8'))
    else:
        return None


api_info = get_api_data()

if api_info is not None:
    print("The weather in" )
    for a, b in api_info.items():
        print('{0}:{1}'.format(a, b))

else:
    print('[!] Request Failed')
