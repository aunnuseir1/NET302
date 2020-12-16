import json
import requests
from bson import json_util
from pymongo import MongoClient
import sys
import pymongo
import datetime


#api parameters
api_key = '055997a3efcd913f3ef01ff6b8eecd6a'
api_default_url =  'http://api.openweathermap.org/data/2.5/'

date = datetime.datetime.now()
tdate = (date.strftime("%x"))

location = input()
colname = location + tdate

country = 'uk'
headers = {'Content-Type': 'application/json','Authorization': 'Bearer {0}'.format(api_key)}

#database
client = pymongo.MongoClient("mongodb://net302_admin:net302@52.23.213.239:27017")
database = client["net302"]
collection = database[colname]
print(client.list_database_names())
print(database.list_collection_names())
colstr = str(collection)


def get_api_data():

    api_url = '{0}weather?q={1},{2}&appid={3}'.format(api_default_url,location,country,api_key)

    response = requests.get(api_url, headers=headers)

    if response.status_code == 200:
        return json.loads(response.content.decode('utf-8'))
    else:
        return None


api_info = get_api_data()

def push():
    if api_info is not None:

        Convert_JSON = json.dumps(api_info)
        Convert_bson = json_util.loads(Convert_JSON)
        insert = collection.insert_one(Convert_bson)

    else:
        print('[!] Request Failed')




if colname in database.list_collection_names():
    for x in collection.find({}, {"_id":0 }):
        print(x)
else:
    get_api_data()
    push()
    print(get_api_data())














