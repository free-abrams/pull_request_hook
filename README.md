### 执行前确认 /home/www 这个目录存在
```php
sudo -u www ssh-keygen -t ed25519 -C "XXXXXX@XXXXX.com"
```
### 克隆仓库后 ./.git 给 www 用户权限
```php
chwon -R www .git
```
### 项目根目录给www用户
```php
chwon -R www /project
```
### 然后执行如下
```php
sudo -u www git pull
```
