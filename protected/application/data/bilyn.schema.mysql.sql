/*
to find user's friend:find user's circle first,user's friend at least belong to
"general_friend" circle
to find friend's circle:find friend first, then search them circle
*/
CREATE TABLE bln_user
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(128) NOT NULL,
	password VARCHAR(128) NOT NULL,
	salt VARCHAR(128) NOT NULL,
	email VARCHAR(128) NOT NULL,
	profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_roleincircle
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	rolename VARCHAR(128) NOT NULL,
	profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_circle
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	circlename VARCHAR(128) NOT NULL,
	profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*each login member can belong to no-circle or multiple circle*/
/*each user in circle have at least one role,can also have multiple role*/
/*the lowest role is member in circle, the priority of roles in circle like:*/
/*member->operator->adminitrator*/
/*examples of operator role have: */
/*task_assigner,activity_organizer,and so on*/
CREATE TABLE bln_circleuser
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	user_id INTEGER NOT NULL,
        circle_id INTEGER NOT NULL,
        role_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*one group can only belong to one circle*/
/*one group can only own one role, this role is the role in circle*/
/*group is convenient in case that assign one role to a lot of member*/
/*by default, there are groups match to each role with name of group_role*/
/*each circle can have only groups match to corresponding role*/
/*todo:seems no need create group in circle, can retieve role_group */
/*by using same role of user*/
/*
CREATE TABLE bln_group
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	groupname VARCHAR(128) NOT NULL,
        circle_id INTEGER NOT NULL,
        role_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_groupuser
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	user_id INTEGER NOT NULL,
        group_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
*/

CREATE TABLE bln_service
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	servicename VARCHAR(128) NOT NULL,
        servicetype_id INTEGER NOT NULL,
        service_tag VARCHAR(128),/*use for search*/
	profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*service is divided into serveral category, for example "estate","home related
","educate" and so on*/
CREATE TABLE bln_service_type
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	tyename VARCHAR(128) NOT NULL,
	profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*every service is composed of operations,operation must belong to one service*/
CREATE TABLE bln_service_operation
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	operationname VARCHAR(128) NOT NULL,
        service_id INTEGER NOT NULL,
 /*       circleroleinservice_id INTEGER NOT NULL,*/
        profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*operation transaction record every operation transaction*/
/*it is important to corelate all infomation between service and resource*/
CREATE TABLE bln_operation_transaction
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	transactionname VARCHAR(128) NOT NULL,
        operation_id INTEGER NOT NULL,
        operator_id INTEGER NOT NULL,
        starttime DATE NOT NULL,
        endtime DATE NOT NULL,
        profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*circle can be working circle, friend circle and member circle to service*/
/*generally, service has its own service, that means each service will build
own circle*/
/*basically, there are two types of circle, one is service circle, second
is friend circle. for service circle, one service own three circle, they are
working team, member team and friend team.
for for friend circle, no member team circle.one friend circle own friend
service.the creater of friend service can add neccessary operations into it.
In summary, one service can own at most 2 basic team, that are working team
and target team. working team can contain individual or members of other circles.
same way, member team and friend team can contain individual or member of other
circles.
each team of service have own roles, each role can execute some operations.
*/
/*
To design a service, should design team first, then each team can add members,
then design role in teams, then design operations in role.
*/
CREATE TABLE bln_service_circle
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	service_id INTEGER NOT NULL,
        circle_id INTEGER NOT NULL,
        roleinservice_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*the value should be:working team,friend team,member team*/
CREATE TABLE bln_circleroleinservice
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	rolename VARCHAR(128) NOT NULL,
        profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*all operation in service should be divided into three category:*/
/*working team's operation:*/
/*friend team's operation:*/
/*member team's operation:*/
/*
CREATE TABLE bln_service_circleroleinservice_operation
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	operatio_id INTEGER NOT NULL,
        circle_id INTEGER NOT NULL,
        roleinservice_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
*/

/*each operation much be executed by some role in one circle*/
/*to find user's circle:search bln_user_circle table, then*/
/*then to find user's service:search bln_service_circle table*/
/*then to find circle's corresponding role: in bln_service_circle*/
/*to find user's team role:circleroleinservice determind user's team role*/
/*search bln_service_roleincircle_operation table can find operations*/
/*belong to user*/
/*the following table user to store operation belong to each role in circle*/
CREATE TABLE bln_service_roleincircle_operation
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	operation_id INTEGER NOT NULL,
        circle_id INTEGER NOT NULL,
        roleincircle_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*find services in community:search bln_community_circle*/
/*service community attribute usually is determind by scope of member team*/
/*so just search service's member team's community to find service's commu*/
/*find circle in community:search bln_community_circle*/
/*circle maybe do not have community attribute*/
/*community attribute is useful to user when he want search friends,service */
/*from his community or near community,user's community attribute is determind */
/*by his circle's community attribute, bln_community_circle */
/*and by user's profile of location setting, bln_community_user*/
CREATE TABLE bln_community
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	communityname VARCHAR(128) NOT NULL,
	profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_community_circle
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	community_id INTEGER NOT NULL,
        circle_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_community_user
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	community_id INTEGER NOT NULL,
        user_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*community will be orgainized in tree structure*/
CREATE TABLE bln_community_relation
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	community_id INTEGER NOT NULL,
        community_id INTEGER NOT NULL,
        relation_id  INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*parent or child*/
CREATE TABLE bln_community_relation_type
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	relationname INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Message service*/
/*Message service is build-in service, will be used by all other service*/
/*To build a service, the following db steps are required:*/
/*
1.register in bln_service table, built-in type for built-in service
1.1 design team for service
1.3 design role in team.
1.4 design operations in role.
1.5 add individual or circle member into team
1.6 assign role to team member.
*/
/*for message service*/
/*
1.service name: message, built-in
1.1 service team: receiver team and sender team
1.2 service team role: sender, receiver
1.3 service operations:
    sender: compose/modify/delete message
    receiver:reply/relay/comment/expand lightbox
*/
/*
1.find message sender
    a.find user_id from bln_operation_transaction table
2.find message sender circle, sometime the
    a.find operation_id from bln_operation_transaction table
    b.find circle_id by operation_id, generally operation_id only belong to
one circle, if find circles of operation_id more than 1, can meantime use
user's circle to determind circle together
*/
CREATE TABLE bln_message
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	messagetitle VARCHAR(128) NOT NULL,
        operation_transaction_id INTEGER NOT NULL,/*operation_id is important to find
corelate information to other resource and service*/
        messagebody VARCHAR(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_message_receiver
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,	
        receiver_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE bln_message_circle
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        receivecircle_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


