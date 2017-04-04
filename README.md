NLP_API
===============

## 后台-NLP 数据交换格式
```json
{
    "1.txt": {
        "code": 0,
        "message": "success",
        "title": "习近平向博鳌亚洲论坛2017年年会开幕式致贺信",
        "time": "2017-03-26",
        "abstract": "国家主席习近平25日向博鳌亚洲论坛2017年年会开幕式致贺信。",
        "keywords": [
            {
                "word": "习近平",
                "frequency": 3
            }
        ],
        "sentiment": 0.8
    }
}
```

## 提供接口

### 上传文件

#### URL
/nlp_api/public/upload

#### 方法
POST

#### 参数
files   //文件组（后缀为txt的文本文件）  
lang    //语言（zh-CN/en）大小写敏感

#### 返回值
无

#### 错误状态码
400 参数为空或错误  
500 文件格式不正确(只接受后缀为txt的文本文件)

***

### 删除缓存文件

#### URL
/nlp_api/public/unload

#### 方法
GET

#### 参数
无

#### 返回值
无

#### 错误状态码
无

***
