charset utf8;
use hewdb;
create table chat_tbl(chat_no SERIAL not null,chat_id varchar(16) not null,chat_kaiwa nvarchar(1024),item_date varchar(25),primary key(chat_no));

insert into chat_tbl values(1,'hal_nagoya','今日の科目は？','2017/10/20 21:31:30');
insert into chat_tbl values(2,'hal_it','DBとSDだったはず','2017/10/20 21:31:50');
insert into chat_tbl values(3,'hal_sd','そうだねその科目だね','2017/10/20 21:32:10');
insert into chat_tbl values(4,'hal_intyo','課題も忘れないようにね','2017/10/20 21:33:35');
