CREATE TABLE bln_user
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(128) NOT NULL,
	password VARCHAR(128) NOT NULL,
	salt VARCHAR(128) NOT NULL,
	email VARCHAR(128) NOT NULL,
	profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
circle can add into service as one role of workingteam, servedteam,friend teams
*/
CREATE TABLE bln_circle
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	circlename VARCHAR(128) NOT NULL,
 /*      defaultservice INTEGER NOT NULL,*/
	profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_circle_child
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	parentcircleid INTEGER NOT NULL,
        childcircleid   INTEGER NOT NULL
  /*      foreign key ('parentcircleid') references 'bln_circle' ('_id') on delete cascade on update cascade,
        foreign key ('childcircleid') references 'bln_circle' ('_id') on delete cascade on update cascade
*/
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_circle_user
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	user_id INTEGER NOT NULL,
        circle_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
service is the core of whole system.
*/
CREATE TABLE bln_service
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	servicename VARCHAR(128) NOT NULL,
   /*   default_workingteam_id INTEGER NOT NULL,
        default_friendteam_id INTEGER,
        default_serviceforteam_id INTEGER,   */
	profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
there are 3 types of team:workingteam, servedteam,friendteam
*/
CREATE TABLE bln_serviceteamtype
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	teamtype VARCHAR(128) NOT NULL,
	profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
This table define service's team.
One service can have only servedteam, for example individual service, business service
one service can have only workingteam, for example friend circle.
one service can have all 3 kinds of team, for example business service.
*/
CREATE TABLE bln_serviceteam
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	service_id INTEGER NOT NULL,
    circle_id INTEGER NOT NULL,
    teamtype_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
This table is used for individual service.
for individual service, it's workingteam have only one member of himself
other team can find in bln_serviceteam table
Everyone has its own service, use for publish his own message and used 
for connecting to her friends. look like facebook friends and weibo friends.
Each one may have multiple individual service, like google's circle, all
individual service will merge when user access them in UI.
To search user's friend, can following steps like below:
1.search bln_service_user for finding user's individual service
2.search bln_service_teamtype to find service's servedteam.
3.for example, one can create a friend circle, actually it is a friendcircle
service, meanwhile he can also create his own company's circle, all these can
display in user's UI as user's circles.
*/
CREATE TABLE bln_service_user
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	service_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
service category such as educate, sport club and so on.
*/
CREATE TABLE bln_servicecategory
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	categoryname VARCHAR(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_service_servicecategory
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	service_id INTEGER NOT NULL,
        servicecategory_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*service type is:
individual service apply for individual usage,such as weibo
circle service apply for circle usage,has only workingteam.
business service apply for business purpose usage, usually at least have
working team and servedteam.
*/
CREATE TABLE bln_servicetype
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	typename VARCHAR(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
if do not specify service type, treat as business service
*/
CREATE TABLE bln_service_servicetype
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	service_id INTEGER NOT NULL,
        servicetype_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*authtype include: role, task.*/
CREATE TABLE bln_authtype
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	typename VARCHAR(128) NOT NULL,
        description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*scopetype include: serviceteam,user.*/
CREATE TABLE bln_auth_scope_type
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	scopetype VARCHAR(128) NOT NULL,
        description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
*authitem used in user's scope and serviceteam scope,
*if authscopetype is user, authscope_id is user's id
*if authscopetype is serviceteam, authscope_id is serviceteam's id
*if authscope_id is -1001, means authitem is available for all user in scope
*/

CREATE TABLE bln_authitem
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	authname VARCHAR(128) NOT NULL,
	authtype_id INTEGER NOT NULL,
	authscopetype_id INTEGER NOT NULL,
	authscope_id INTEGER NOT NULL,
    description TEXT,
    bizrule TEXT,
    authdata    TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
 * child scope must >= parent scope, means child scope must in same scope of parent
 * or child scope must be "all scope" of serviceteam or user
 * role can have task child, however task can not have role child
 * */
CREATE TABLE bln_authitem_child
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	parent_id INTEGER NOT NULL,
    child_id INTEGER NOT NULL    
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*define operations for each authitem, finally all authitem contain operations*/
CREATE TABLE bln_authitem_operation
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    authitem_id INTEGER NOT NULL,
	operation_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


/*assign authitem to user*/
CREATE TABLE bln_authitem_user
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    authitem_id INTEGER NOT NULL,
	user_id INTEGER NOT NULL  
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
authitem can also assign to a circle
*/
CREATE TABLE bln_authitem_circle
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    authitem_id INTEGER NOT NULL,
	circle_id INTEGER NOT NULL  
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
authitem can also assign to a serviceteam
*/
CREATE TABLE bln_authitem_serviceteam
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    authitem_id INTEGER NOT NULL,
	serviceteam_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*feature is the group of operations*/
CREATE TABLE bln_operation
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	operationname VARCHAR(128) NOT NULL,
    description TEXT
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*use this table to add configuration for operation*/
CREATE TABLE bln_operation_configuration
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    operation_id INTEGER NOT NULL,
	configuration_key VARCHAR(128) NOT NULL,
    configuration_value VARCHAR(128) NOT NULL,
    description TEXT
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*feature can contain features*/
CREATE TABLE bln_authitem_operation
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	authitem_id INTEGER NOT NULL,
    operation_id   INTEGER NOT NULL        
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*operation transaction record every operation transaction*/
/*it is important to corelate all infomation between service and resource*/
CREATE TABLE bln_operation_transaction
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	transactionname VARCHAR(128) NOT NULL,
        serviceteam_id INTEGER NOT NULL,
        user_id INTEGER NOT NULL,
        operation_id INTEGER NOT NULL,
        starttime DATE NOT NULL,
        endtime DATE NOT NULL,
        profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_community
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	communityname VARCHAR(128) NOT NULL,
	profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_community_serviceteam
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	community_id INTEGER NOT NULL,
        serviceteam_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*community will be orgainized in tree structure*/
CREATE TABLE bln_community_child
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	parent_community_id INTEGER NOT NULL,
        child_community_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
The system will support developing new service by user or company's team.
To develop new service,one should following tasks as below:
1.design service functions, such as message function, pooling function
each function usually contain a series of operation.
2.decide service's team, that are working team, friend team, servicefor team
3.design role in each team, can use template or create new template.
3.1 design operations and assign authorized role in it.
4.add user or circle into team, assign proper role to user or circle.
*/
/*
some basic actions for login user can be done in database as below:
1.find user's circle: search bln_user_circle table
2.find user's service:
    a.search bln_service_user_teamrole
    b.search bln_circle to find default service
    c.search bln_service_circle_teamtype, find circle's more service
3.find user's operation in service & circle
    a.find user's service and its'teamtype first,
after user at least own role in service as basic "team member".
    b.find user's role in table bln_service_user_teamrole
    c.find user's role in table bln_service_circle_teamrole
*/

/*message feature*/
/*basic service is the start point of all service which must include message*/
/*message service use for message flow in individual,circle and service*/
CREATE TABLE bln_message
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        author_id   INTEGER DEFAULT -1,/*if user-created message,set this value*/
        author_type_id INTEGER DEFAULT -1,/*determind author as user, circle, serviceteam*/
	messagetitle VARCHAR(128) NOT NULL,
        messagetext TEXT  
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_message_media
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        message_id INTEGER NOT NULL,
        media_id INTEGER NOT NULL,
        media_sourcetype_id INTEGER NOT NULL/*embed media or external media*/
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_media
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        media_title VARCHAR(128) NOT NULL,
        media_description VARCHAR(128),
        media_location  VARCHAR(128),
        media_type INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
types include:picture,vedio,music and more
*/
CREATE TABLE bln_mediatype
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        typename VARCHAR(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*embed media or external media*/
CREATE TABLE bln_message_mediasourcetype
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        sourcetypename VARCHAR(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_message_transfer
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        sender_id INTEGER NOT NULL,
        sender_type_id INTEGER NOT NULL,/*user,circle or serviceteam*/
        receiver_id INTEGER NOT NULL,
        receiver_type_id INTEGER NOT NULL,/*user,circle or serviceteam*/
        transfer_type_id INTEGER NOT NULL,/*forward message or original message*/
	comment_message_id INTEGER DEFAULT -1,/*-1 means no comment message*/
        original_message_id INTEGER NOT NULL,       
        previous_transfer_id INTEGER default -1,/*-1 means no previous forwarder,only use for forward message*/
        operation_transaction_id INTEGER NOT NULL,
        transfer_configuration_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*message can publish to friend, use this table to define publish properties*/
CREATE TABLE bln_message_publish
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	transfer_message_id INTEGER NOT NULL,
        publish_receiver_id INTEGER NOT NULL,
        publish_receiver_type_id INTEGER NOT NULL,/*publish receiver can be user,circle,serviceteam*/
        publish_configuration_id INTEGER NOT NULL        
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*this table is use to define read strategy for publish message*/
CREATE TABLE bln_message_publish_read
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	message_publish_id INTEGER NOT NULL,
        publish_reader_id INTEGER NOT NULL,
        publish_reader_type_id INTEGER NOT NULL,/*publish reader can be user,circle,serviceteam*/
        publish_reader_configuration_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*message can publish to friend, use this table to define publish properties*/
CREATE TABLE bln_configuration
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        configurationname   VARCHAR(30) NOT NULL,
        description   TEXT 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*this table is use to define read strategy for publish message*/
CREATE TABLE bln_configuration_data
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	configuration_id INTEGER NOT NULL,
        configration_key VARCHAR(30) NOT NULL,
        configuration_value VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*configuration will be orgainized in tree structure*/
CREATE TABLE bln_configuration_child
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	parent_configuration_id INTEGER NOT NULL,
        child_configuration_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Task management feature*/
/*
operations belong to task management:
create task, assign task, update task status, close task.
view task by outside
*/
/*
check pending task for user:

*/
CREATE TABLE bln_task
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	tasktitle VARCHAR(128) NOT NULL,
        taskdescription INTEGER NOT NULL,
        task_owner_id   INTEGER,
        starttime INTEGER,
        expected_endtime INTEGER,        
        endtime INTEGER/*set endtime to a largvalue if not done*/
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_taskphase
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	phasename VARCHAR(128) NOT NULL,
        phasedescription    VARCHAR(128) NOT NULL,
        task_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_tasktransaction
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	transactionname VARCHAR(128) NOT NULL,
        transactiondescription    VARCHAR(128) NOT NULL,
        starttime   INTEGER,
        endtime INTEGER,
        task_id INTEGER NOT NULL,
        taskphase_id    INTEGER,
        operation_transaction_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*task status is used for check status of task from outside user*/
CREATE TABLE bln_taskstatus
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	statustitle VARCHAR(128) NOT NULL,
        statusdescription VARCHAR(256) NOT NULL,
        tasktransaction_id  INTEGER,
        teamrole_to_view INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Activity feature*/
