# -*- coding: utf-8 -*-

from DataBase import *
from GetRepositories import *
import MySQLdb, sys
import wx

connect()
ProjectID = 'f'

class MyApp(wx.Frame):

    def __init__(self, *args, **kw):
        super(MyApp, self).__init__(*args, **kw)

        self.init_ui()

    def init_ui(self):
        self.SetTitle('テキストボックス')
        self.SetSize((600, 400))
        self.Show()

        panel_ui = wx.Panel(self, -1, pos=(0, 0), size=(600, 400))

        self.label = wx.StaticText(panel_ui, -1, '', pos=(10, 10))

        label = wx.StaticText(panel_ui,label='ユーザー名',size = (300,200))
        self.box1 = wx.TextCtrl(panel_ui, -1, pos=(10, 50))
        label = wx.StaticText(panel_ui,label='プロジェクト名',size = (300,200))
        self.box2 = wx.TextCtrl(panel_ui, -1, pos=(150, 50))
        btn = wx.Button(panel_ui, -1, 'データ挿入', pos=(10, 90))
        btn.Bind(wx.EVT_BUTTON, self.clicked)

    def clicked(self, event):
        UserName = self.box1.GetValue()
        ProjectName = self.box2.GetValue()
        ProjectID = GetProjectID(UserName, ProjectName)
        if ProjectID == 'f':
            self.label.SetLabel('ユーザー名またはプロジェクト名が間違っています。')
        else :
            DataIn(ProjectID, UserName, ProjectName)
            CEnd()
            self.label.SetLabel('データが挿入されました。')
        self.box1.Clear()
        self.box2.Clear()

app = wx.App()
MyApp(None)
app.MainLoop()