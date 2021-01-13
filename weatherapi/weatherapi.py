#!/usr/bin/python
#encoding: utf-8
#!/usr/bin/env python

#libaries
import json
import requests
from bson import json_util
from pymongo import MongoClient
import sys
import pymongo
import datetime
import sys
import pymongo
import socket
from geopy import Nominatim


#api parameters
api_key = '055997a3efcd913f3ef01ff6b8eecd6a'
api_default_url =  'http://api.openweathermap.org/data/2.5/'

date = datetime.datetime.now()
tdate = (date.strftime("%x"))
location = sys.argv[1]
locator = Nominatim(user_agent="net302_aun")
geolocation = locator.geocode(location + ",UK")
latitude = geolocation.latitude
longitude = geolocation.longitude
colname = location + tdate
country = 'uk'
headers = {'Content-Type': 'application/json','Authorization': 'Bearer {0}'.format(api_key)}
urlpar = 'lat={0}&lon={1}&exclude=current,minutely,hourly,alerts&units=metric&appid={2}'.format(latitude,longitude,api_key)


#database connection details
client = pymongo.MongoClient("mongodb://net302_admin:net302@52.23.213.239:27017")
database = client["net302"]
collection = database[colname]
print(client.list_database_names())
print(database.list_collection_names())
colstr = str(collection)




#calling the api and gets the required data.
def get_api_data():

    api_url = '{0}onecall?{1}'.format(api_default_url,urlpar)
    print (api_url)
    response = requests.get(api_url, headers=headers)

    if response.status_code == 200:
        return json.loads(response.content.decode('utf-8'))
    else:
        return None


api_info = get_api_data()


#converts the data from BSON to JSON and inserts into database. then dumps the JSON file to be used.
def push():
    if api_info is not None:

        Convert_JSON = json.dumps(api_info)
        Convert_bson = json_util.loads(Convert_JSON)
        insert = collection.insert_one(Convert_bson)
        my_json = json.dumps(get_api_data())  
    
    else:
        print('[!] Request Failed')
        

my_json = json.dumps(get_api_data())

#checks if the input exists in the database, by running the name through the collections which exist if it exits it dumps the JSON file read for the php script to pick it up. 
if colname in database.list_collection_names():
    for x in collection.find({}, {"_id":0 }):
        my_json = json.dumps(get_api_data())

else:
    get_api_data()
    push()




