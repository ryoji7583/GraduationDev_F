# -*- coding: utf-8 -*-
#!/usr/bin/env python

import urllib
import urllib2
import sys
import requests
import os, json, functools

argvs = sys.argv
argc = len(argvs)
print argvs
print argc

Owner = sys.argv[1]
RepoName = sys.argv[2]
title = sys.argv[3]
head = sys.argv[4]
base = sys.argv[5]
body = sys.argv[6]
# User = sys.argv[7]
# token = sys.argv[8]
# payload = {
#           "title": title,
#           "body": body,
#           "head": head,
#           "base": base
#        }
#
# url='https://api.github.com/repos/%s/%s/pulls' % (Owner, RepoName)
# GitHub Traffic API
# https://developer.github.com/v3/repos/traffic/
# response = requests.post(url,auth=(User, token), json=payload)
# print(response.status_code)
# print(response.text)
print RepoName
print title
print head
print base
print body
# print User
# print token