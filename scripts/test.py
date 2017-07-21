# -*- coding: <utf-8> -*-
import mysql.connector
conn = mysql.connector.Connect(
    host='localhost', user='root', password='root', database='philos')
cursor = conn.cursor()
add_philos = ("INSERT IGNORE INTO influences_tmp"
              "(source, target) "
              "VALUES (%(source)s, %(target)s)")

data_philos = {'target': 'David Hume', 'source': 'A. J. Ayer'}
#data_philos = (source, target)
cursor.execute(add_philos,data_philos)

conn.commit()
cursor.close()
conn.close()
