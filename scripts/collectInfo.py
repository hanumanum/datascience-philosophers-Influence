# -*- coding: <utf-8> -*-
'''
import csv
with open("philosophers-12459.csv", "rb") as f:
    reader = csv.reader(f, delimiter="\t")
    for i, line in enumerate(reader):
        print line[0]
'''

import urllib2
line = "Tigran Aleksanyan"

response = urllib2.urlopen(url)
webContent = response.read()
