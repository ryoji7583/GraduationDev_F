#!/usr/bin/env python
# -*- coding: utf-8 -*-

from DataBase import *
from GetRepositories import *
import MySQLdb, sys

connect()
ProjectID = 'f'

while ProjectID == 'f':
    print ('ユーザー名を入力してください。')
    input_user = raw_input('>>>  ')
    print ('プロジェクト名を入力してください。')
    input_project = raw_input('>>>  ')
    ProjectID = GetProjectID(input_user,input_project);
    if ProjectID == 'f':
        print('ユーザー名またはプロジェクト名が間違っています。')


print ('----------データを送信しています----------')
DataIn(ProjectID,input_user,input_project)
# GetRecord()
#変更点を保存する
CEnd()
print 'Save完了'
