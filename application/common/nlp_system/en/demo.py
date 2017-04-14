# -*- encoding:utf-8 -*-
import random

from pyteaser import  Summarize,keywords,keywords5
from pprint import pprint
import json
import os
from aylienapiclient import textapi
import sys


def singleTxt(txtname):
    code=0
    message="success"
    title=""
    time=""
    text=""

    f2=open(txtname)
    i=0
    while 1:
        line=f2.readline()
        if not line:
           break
        if i==0:
            title=line
        if i==1:
            time=line
        if i>=2:
            text=text+line
        i=i+1

    if i<2:
        code=1
        message="wrong format"
    key2=keywords5(text)
    # pprint(key2)
    summaries=Summarize(title, text)
    # pprint(summaries)
    abstract=''
    for summary in summaries:
        abstract=abstract+summary+" "



    client = textapi.Client("1808166e", "16c6e9275d7a517192b517abe12c9b35")
    sentimentstr = client.Sentiment({'text': text})
    sentiment=sentimentstr['polarity_confidence']
    positive = sentimentstr['polarity']
    if positive=='positive':
        sentiment=abs(sentiment-0.5)*2*0.8+0.2
    if positive=='negative':
        sentiment=-(abs(sentiment-0.5)*2*0.8+0.2)
    if positive=='neutral':
        if len(text)%2==1:
            sentiment = (0.2 - abs(sentiment - 0.5) * 2 * 0.2)
        else:
            sentiment = -(0.2 - abs(sentiment - 0.5) * 2 * 0.2)

    data={
        'code':code,
        'message':message,
        'title':title.strip('\n'),
        'time':time.strip('\n'),
        'abstract':abstract,
        'keywords':key2,
        'sentiment':sentiment
    }
    return data


path = sys.argv[1] #文件夹目录
files= os.listdir(path) #得到文件夹下的所有文件名称
articles={}
for file in files: #遍历文件夹
     if not os.path.isdir(file): #判断是否是文件夹，不是文件夹才打开
         data = singleTxt(path+'/'+file)
         articles[file] = data
json_str = json.dumps(articles)
print(json_str) #打印结果