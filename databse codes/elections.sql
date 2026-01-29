use OnlineVotingSystem;
select * from Users;

show tables;

create table elections(
id int auto_increment primary key,
election_topic varchar(255),
no_of_candidates int(11) ,
starting_date date,
ending_date date,
status varchar(200),
inserted_by varchar(200),
inserted_on date
)

SELECT * FROM elections WHERE id = 1;
DELETE FROM elections WHERE id = 16;
DELETE FROM elections WHERE id = 17;
DELETE FROM elections WHERE id = 18;
DELETE FROM elections WHERE id = 19;
DELETE FROM elections WHERE id = 21;

select * from elections;


CREATE TABLE candidate_details (
id INT(11) NOT NULL AUTO_INCREMENT,
election_id INT(11) DEFAULT NULL,
candidate_name VARCHAR(255) DEFAULT NULL,
candidate_details TEXT DEFAULT NULL,
candidate_photo TEXT DEFAULT NULL,
inserted_by VARCHAR(255) DEFAULT NULL,
inserted_on DATE DEFAULT NULL,
PRIMARY KEY (id)
)




select * from candidate_details;
DELETE FROM candidate_details WHERE id = 4;