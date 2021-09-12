<?php
#----------------------------------------------------------------------------
#----------------------         CÁC KIỂU DỮ LIỆU       ----------------------
# $table->string("tên",0->255) : kiểu chữ
# $table->text("tên",1->4)     : kiểu văn bản
# $table->int("tên",1->5)      : kiểu số nguyên
# $table->id_r("tên")          : kiểu id liên kết
# $table->float("tên")         : kiểu float
# $table->double("tên")        : kiểu double
# $table->bit("tên")           : kiểu true / false
# $table->date("tên")          : kiểu ngày (YYYY/MM/DD)
# $table->datetime("tên")      : kiểu thời gian và ngày (YYYY/MM/DD H:m:s)
# $table->time("tên")          : kiểu thời gian (H:m:s)
#------   Nhập Code   --------
#----  Thông Tin đăng nhập ---
$table = new Table("user");
$table->string("username");
$table->string("password",128);
$table->string("remember_login");
#---  Thông Tin người dùng ---