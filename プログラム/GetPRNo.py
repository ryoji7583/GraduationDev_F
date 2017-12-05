#!/usr/bin/env python
# -*- coding: utf-8 -*-
import os, json, functools
from urllib2 import urlopen, Request

# GitHub Traffic API
# https://developer.github.com/v3/repos/traffic/
def openTrafficAPI (owner, repo, path):
    url = "https://api.github.com/repos/%s/%s/%s" % (owner, repo, path)
    return urlopen (Request (url))

# 取ってくるデータ
paths = [
    'pulls?state=close',
]

def GetDataList(User,Project):
    connections = []
    # openTrafficAPI関数の部分適用 (認証情報を環境変数から得て)
    fAPI = functools.partial (openTrafficAPI,
                                User,
                                Project)
    # open connections
    connections = [fAPI (p) for p in paths]
    # JSONパース
    for c in connections:
       datalist = json.loads (c.read ())
    [c.close () for c in connections if c is not None]          # 後始末
    del connections
    return datalist

def GetNumber(User1, Project1, PRNo):
    PullRequestList = GetDataList(User1,Project1)
    PRnumber = 0
    dictionary1 = PullRequestList[0]
    Max = dictionary1[u"number"]
    number = Max - 1
    while (number >= 0):
        PRdictionary = PullRequestList[number]
        if PRdictionary[u"id"] == int(PRNo):
            PRnumber = PRdictionary[u"number"]
        number = number - 1
    return PRnumber