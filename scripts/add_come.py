#!/usr/bin/env python3

# Usage: ./scripts/add_come.py

url = "https://codi.kanthaus.online/come/download"

import urllib.request
with urllib.request.urlopen(url) as response:
   markdown = response.read().decode()

import yaml
parts = markdown.split('---')
frontmatter = parts[1]
frontmatter = yaml.safe_load(frontmatter)
date = frontmatter['date']

destination_directory = 'user/pages/40.governance/90.minutes/{}_CoMe'.format(date)
import os
import sys
if os.path.isdir(destination_directory):
    print(destination_directory, 'already exists! Exiting...')
    sys.exit(1)

os.mkdir(destination_directory)
destination_file = os.path.join(destination_directory, 'item.md')
with open(destination_file, 'w+') as f:
    f.write(markdown)
    print('Done! Type `git status` to see the changes!')
