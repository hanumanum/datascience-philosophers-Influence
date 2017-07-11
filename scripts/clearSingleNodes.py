# -*- coding: <utf-8> -*-
import csv
writer = csv.writer(open("philosophers-pairs-cleaned-12459.csv", "wb"))

with open("philosophers-pairs-12459.csv", "rb") as f:
    reader = csv.reader(f)
    for i, line in enumerate(reader):
        if line[0] != "":
            writer.writerow(line)

writer.close()
