# -*- coding: <utf-8> -*-
import regex as re
import mysql.connector
conn = mysql.connector.Connect(
    host='localhost', user='root', password='root', database='philos')
cursor = conn.cursor()
add_philos = ("INSERT IGNORE INTO philosopers"
              "(name, birthyear) "
              "VALUES (%s, %s)")

with open("../PhilosophersData/list5_upto19th-20th.txt") as f:
    for line in f:
        ln = line.split("(")
        if len(ln) == 2:
            name = ln[0].rstrip().rstrip(",")
            year = re.search(r'\d+', ln[1]).group()
            if len(str(year)) < 3:
                year = int(year) * 100 - 50
            print name + str(year)
            data_philos = (name, year)
            cursor.execute(add_philos, data_philos)

conn.commit()
cursor.close()
conn.close()
