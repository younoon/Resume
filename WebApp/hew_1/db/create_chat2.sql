charset utf8;
use hewdb;
create table chat2_tbl(chat_no SERIAL not null,chat_id varchar(16) not null,chat_kaiwa nvarchar(1024),item_date varchar(25),primary key(chat_no));
