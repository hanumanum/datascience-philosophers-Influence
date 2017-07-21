# -*- coding: <utf-8> -*-
xpaths = [
    '(//ul[@class="NavContent"])[1]/li/div/div[@class="hlist"]/ul/li/a/@title' #from Kant
    ,'(//ul[@class="NavContent"])[1]/li/div/a/@title' #from Mikhail_Bakunin
]


urlStart = "https://en.wikipedia.org/wiki/" 
#url = "https://en.wikipedia.org/wiki/Georg_Wilhelm_Friedrich_Hegel"
#url = "https://en.wikipedia.org/wiki/Mikhail_Bakunin"

from lxml import html
import requests
import mysql.connector
conn = mysql.connector.Connect(host='localhost', user='root', password='root', database='philos')
selectCursor = conn.cursor(buffered=True)
insertCursorURL = conn.cursor()
insertCursorPair = conn.cursor()

get_philos = "SELECT name as pilName FROM philosopers ORDER BY name"

insert_philos = ("INSERT IGNORE INTO influences_tmp"
                 "(source, target)"
                 "VALUES (%(source)s, %(target)s)")

insert_faild_urls = ("INSERT INTO failed_urls" 
                     "(link)"
                     "VALUES (%(linkk)s)")

selectCursor.execute(get_philos)

for pilName in selectCursor:
    url = urlStart+pilName[0].replace(" ","_");
    page = requests.get(url)
    tree = html.fromstring(page.content)
    #print(url)
    #try get info by multiple xpaths
    for i in range(0,len(xpaths)):
        Influences = tree.xpath(xpaths[i])
        Influenced = tree.xpath(xpaths[i].replace("[1]","[2]",1))
        #print(xpaths[i])
        #print(xpaths[i].replace("[1]","[2]",1))
        if len(Influences)>0:
            break
    
    #if get info faild write about it in database
    if len(Influences)==0 and len(Influenced)==0:
        url_data = {
            "linkk":url
        }
        insertCursorURL.execute(insert_faild_urls,url_data)

    if len(Influences)>0:
        for pilo in Influences:
            pair = {"source":str(pilName[0]),"target":str(pilo)}
            #print("-"*40)
            insertCursorPair.execute(insert_philos,pair)

    if len(Influenced)>0:
        for pilo in Influenced:
            pair = {"source":str(pilo),"target":str(pilName[0])}
            #pair = (pilo,pilName[0])
            insertCursorPair.execute(insert_philos,pair)

    print(pilName)
    conn.commit()

selectCursor.close()
insertCursorURL.close()
insertCursorPair.close()
conn.close()