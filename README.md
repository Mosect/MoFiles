# MoFiles
轻量级PHP文件上传、下载；Lightweight PHP file upload and download

# 使用
1. 搭建PHP环境
2. 将DocumentRoot设置成项目的public目录
3. 设置项目根目录读写权限（最好只将info和files目录设置成可读写，其他目录不能写）
4. 重启服务器

# config.php
config.php 记录了文件信息保存目录和文件保存目录，可以自行更改。
```
// 文件配置（记录信息）目录
const CONFIG_DIR = __DIR__ . '/info/';
// 文件保存目录
const FILES_DIR = __DIR__ . '/files/';
```
