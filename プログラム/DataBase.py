#!/usr/bin/env python
# -*- coding: utf-8 -*-

from GetRepositories import *
import MySQLdb

conn = 'None'
c = 'None'

    #データベースに接続
def connect():
    global conn
    global c
    conn = MySQLdb.connect(
    user='ryoji',
    passwd='android.1429',
    host='localhost',
    db='GitHubData'
    )
    c = conn.cursor()

def GetProjectID(GetUser,GetProject):
    rows = 'NULL'
    dictionary = dict(User=GetUser, Project=GetProject)
    c.execute("SET NAMES utf8")
    sql = "select ProjectID from projectlist where UserName = '{User}' and ProjectName = '{Project}'".format(**dictionary)
    c.execute(sql)
    if c.rowcount == 0:
        return 'f'
    else:
        return c.fetchone()[0]

    # テーブル一覧の取得
def ShowTable(c):
    sql = 'show tables'
    c.execute(sql)
    print('===== テーブル一覧 =====')
    print(c.fetchone())

    # レコードの登録
def DataIn(ID,User,Project):
    Title = GetTitle(User,Project)
    Body = GetBody(User,Project)
    sql = 'insert into PRData values (%s, %s, %s)'
    c.execute(sql, (ID, Title.encode('utf-8'), Body.encode('utf-8')))  # 1件のみ
    print('\n* データを1件登録\n')

    # レコードの取得
def GetRecord():
    c.execute("SET NAMES utf8")
    sql = 'select * from PRData'
    c.execute(sql)
    print('===== レコード =====')
    for row in c.fetchall():
        print('ID:    ' + row[0])
        print('タイトル:        ' + row[1])
        print('説明:        ' + row[2])

    # レコードの削除
def DeleteRecord():
    sql = 'delete from test2 where id=%s'
    c.execute(sql, (2,))
    print('\n* idが2のレコードを削除\n')

def CEnd():
    conn.commit()
    c.close()
    conn.close()
