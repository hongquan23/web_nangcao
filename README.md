#  Project: Học từ vựng thông qua Flashcard 
## Giới thiệu:

1. 👤 Họ và tên Sinh viên: Lương Hồng Quân
2. Mã Sinh viên: 23010423
3. Lớp: K17_CNTT-5
4. Môn học: Web nâng cao (TH3)

# 📋 Mô tả dự án:

#### Dự án website học từ vựng tiếng Anh thông qua flashcard, hỗ trợ người dùng ghi nhớ từ vựng hiệu quả bằng các bộ thẻ học đơn giản, dễ sử dụng. Trang web cung cấp các chế độ học, kiểm tra và theo dõi tiến độ, giúp người học nâng cao vốn từ một cách khoa học và chủ động.


# 💻 Công nghệ sử dụng:

#### 1. PHP (Laravel Framework)
#### 2. Laravel Breeze
#### 3. MySQL (Aiven Cloud)
#### 4. Blade Template
#### 5. Tailwind CSS

# Sơ đồ khối
### Class Diagram
## Sơ đồ khối

![image](https://github.com/user-attachments/assets/4413f737-5cc4-4a0f-8a61-5e6d4484f634)


## Sơ đồ chức năng

![image](https://github.com/user-attachments/assets/2fd917dc-7e61-4e1c-88d8-7003d5e12b8e)



## Sơ đồ thuật toán

![image](https://github.com/user-attachments/assets/876f1d9b-e2b5-47d9-944f-7dd41c9aed34)




# Một số Code chính minh họa

## Model
#### User:

![image](https://github.com/user-attachments/assets/366ef6c9-7b41-4180-a131-a795c65ed728)


#### FlashcardSet:

![image](https://github.com/user-attachments/assets/1a66177c-fec9-41ad-8e43-6340a179cdc5)


#### Flashcard:

![image](https://github.com/user-attachments/assets/34fb3bf6-eed7-4175-9f7d-59e021dff15c)


#### Score:

![image](https://github.com/user-attachments/assets/7f99506b-b449-4e08-bc86-ed0d641cc55b)


## Controller
#### ProfileController:

![image](https://github.com/user-attachments/assets/4f606d33-2a4d-493d-8772-635fa17a9ad6)

![image](https://github.com/user-attachments/assets/6a36bf62-8656-4ac1-a94e-6bba425c0500)



#### FlashcardController:

![image](https://github.com/user-attachments/assets/6cb389cc-bef1-4d56-9886-b9da733cebdc)
![image](https://github.com/user-attachments/assets/41b27e93-ec30-4457-a8f7-b7513e5efbf0)
![image](https://github.com/user-attachments/assets/18a4dfd4-d114-4271-833d-fee987601225)



#### FlashcardSetController:

![image](https://github.com/user-attachments/assets/dfe60e66-6eba-4113-a930-2589876942fb)

![image](https://github.com/user-attachments/assets/e873f639-b7a1-4f53-93e2-63ef257f64a8)

![image](https://github.com/user-attachments/assets/e84e65a6-157e-46f9-9f75-49bf041ddac0)


![image](https://github.com/user-attachments/assets/421c2bd6-b3d3-48c7-be00-d9b0c6e964ba)

![image](https://github.com/user-attachments/assets/23c64aa4-7672-4dba-b300-efc303524a1a)

![image](https://github.com/user-attachments/assets/a4b5fff3-5c14-4e08-a660-ca08a1e4e645)





## View
blade template Cart

## Routes

![image](https://github.com/user-attachments/assets/5ccb5951-4148-468c-8835-ce8f92c61bb1)


# Security Setup
## Sử dụng @CSRF Token để bảo vệ chống tấn công giả mạo yêu cầu từ phía người dùng
![image](https://github.com/user-attachments/assets/36ea0384-faed-4668-9d8d-979eae9fa663)

## Chống XSS
![image](https://github.com/user-attachments/assets/5953f975-5b9d-4416-bc88-de181f85424d)
## Middleware bảo vệ chuyển hướng
![image](https://github.com/user-attachments/assets/67a81e84-5723-41e5-b8fa-5052420a92dc)
## Sử dụng Eloquent ORM chống SQL Injection
![image](https://github.com/user-attachments/assets/396405eb-9144-4582-8e46-c121fdaf9136)
< UPDATE flashcards SET term = 'New term', definition = 'New definition' WHERE flashcards.set_id = ?; >






# Link

## Github Profile : https://github.com/hongquan23/web_nangcao

## Public Web (deployment) link: https://web-nangcao-1.onrender.com

# Một số hình ảnh chức năng chính

## Trang xác thực người dùng:


### Trang đăng nhập:

![image](https://github.com/user-attachments/assets/31750b70-cf0f-4ca8-ae99-6c3de0123f4f)


### Trang đăng ký:

![image](https://github.com/user-attachments/assets/8eb62c33-9e3f-403c-bb0f-6d4fc17feed2)


### Trang quên mật khẩu: 

![image](https://github.com/user-attachments/assets/5c25cde8-23ec-432c-9b65-eea20a57e1e1)


## Trang chủ:

![image](https://github.com/user-attachments/assets/3435ff27-a37a-49ae-8fbb-e973e3466db6)

![image](https://github.com/user-attachments/assets/b196b148-c8a3-4a93-8ac2-f57d2cae3bbb)

## Học Flashcard:

### Trang chính:

![image](https://github.com/user-attachments/assets/91b00ca6-9af8-4d8a-8786-23c5df904288)


### Trang để học:

![image](https://github.com/user-attachments/assets/ced28208-cede-4940-b9a2-7a51eab10580)

### Lmà bài tập:

![image](https://github.com/user-attachments/assets/e19df6bd-1d6f-4775-871f-21d8af014b72)


### Hiển thị kết quả:

![image](https://github.com/user-attachments/assets/c78fb793-a9a7-4e35-aca1-8370dc0f9fb2)

### Biểu đồ trạng thái:
![image](https://github.com/user-attachments/assets/2cd5d924-93c9-4501-9e87-3fc607184017)

# License & Copy Rights
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
