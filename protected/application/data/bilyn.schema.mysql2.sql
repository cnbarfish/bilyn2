CREATE TABLE bln_user
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(128) NOT NULL,
	password VARCHAR(128) NOT NULL,
	salt VARCHAR(128) NOT NULL,
	email VARCHAR(128) NOT NULL,
        defaultservice INTEGER NOT NULL,/*individual service*/
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

CREATE TABLE bln_circle_user
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	user_id INTEGER NOT NULL,
        circle_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
each service must own one working team, but serviceforteam and
friendteam can be null
all service should inherited from a basic service which must include
message feature.
generally all service inherited from 3 kinds of service:
individual service = individual business service, can extend as normal business
service
circle service = have only working team member
normal business service = have many working team member and many servicefor
team members.
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
CREATE TABLE bln_teamtype
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	teamtype VARCHAR(128) NOT NULL,
	profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
This table define service's team.
One service can have only servedteam, for example individual service.
one service can have only workingteam, for example friend circle.
one service can have all 3 kinds of team, for example business service.
*/
CREATE TABLE bln_service_teamtype
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	service_id INTEGER NOT NULL,
        circle_id INTEGER NOT NULL,
        teamtype_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
This table is used for individual service.
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

CREATE TABLE bln_servic_servicecategory
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
CREATE TABLE bln_servic_servicetype
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	service_id INTEGER NOT NULL,
        servicetype_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
this table define team template used for working team,servicefor team
and friend team.
each team template have specific team role.
*/
CREATE TABLE bln_roletemplate
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	templatename VARCHAR(128) NOT NULL,
	profile TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
This table is important
to find all service team roles in service.
To find all operations with team role in service.
If more working team defined for service, can use default working team
or overriding strategy (can not merge strategy).
same strategy can apply to friend team and servicefor team
*/
CREATE TABLE bln_service_roletemplate
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	service_id INTEGER NOT NULL,
        roletemplate_id    INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*define roles for each team in team_template*/
/*please add one role named "teamall" that means all member in team*/
CREATE TABLE bln_roletemplate_role
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        rolename VARCHAR(128) NOT NULL,
	roletemplate_id INTEGER NOT NULL,
        teamtype_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*define operations for each team in team_template*/
CREATE TABLE bln_role_operation
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        roletemplate_role_id INTEGER NOT NULL,
	operation_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*
this table can define all roles in each service.
actually, to find all operations of service
can first find service teamrole first, then find operations
*/
/*CREATE TABLE bln_service_operation
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        operation_id INTEGER NOT NULL,
	service_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
*/
/*because the operation in service is authorized by team role
the user's team role is important for do some operations*/
CREATE TABLE bln_service_user_role
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        roletemplate_role_id INTEGER NOT NULL,
	user_id INTEGER NOT NULL,
        service_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*circle can add into service's working team, servicefor team
and friend team, if want to add whole circle to one service team,
please use "team member" role. If add to whole team,
to make member in circle can work properly with some role, more action
to add user into role is needed*/
CREATE TABLE bln_service_circle_teamrole
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        service_id INTEGER NOT NULL,
	circle_id INTEGER NOT NULL,
        teamrole_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*feature is the middle level between service and operation*/
/*feature usually contain a lot operation*/
/*feature may have own role template*/
/*feature can be added into service*/
/*by feature, can add a group of operations into service*/
CREATE TABLE bln_feature
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	featurename VARCHAR(128) NOT NULL,
        description TEXT
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*service may have one or more feature, if operation do not belong to any
feature in service, can add into service by bln_service_operation*/
CREATE TABLE bln_service_feature
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        service_id INTEGER NOT NULL,
	feature_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*feature usually has own role template, on the otherhand, service usually
has own role template, these two template mix togther to form the roles in
service.
if one service add one feature into service, the all roles include
old roles in service add all roles bring into by feature.*/
CREATE TABLE bln_feature_roletemplate
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        feature_id INTEGER NOT NULL,
	template_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*operation transaction record every operation transaction*/
/*it is important to corelate all infomation between service and resource*/
CREATE TABLE bln_operation_transaction
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	transactionname VARCHAR(128) NOT NULL,
        service_id INTEGER NOT NULL,
        user_id INTEGER NOT NULL,
        teamtemplate_operation_id INTEGER NOT NULL,
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

CREATE TABLE bln_community_service
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	community_id INTEGER NOT NULL,
        service_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*community will be orgainized in tree structure*/
CREATE TABLE bln_community_relation
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
	message_title VARCHAR(128) NOT NULL,
        message_body TEXT,
        operation_transaction_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_message_embededmedia
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        message_id INTEGER NOT NULL,
        embededmedia_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_message_externalmedia
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        message_id INTEGER NOT NULL,
        externalmedia_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*some operation can be added into message in a div tag*/
CREATE TABLE bln_message_linkedoperation
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        message_id INTEGER NOT NULL,
        operation_id INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_embededmedia
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        media_title VARCHAR(128) NOT NULL,
        media_description VARCHAR(128),
        media_location  VARCHAR(128),
        media_type INTEGER NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE bln_externalmedia
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

/*if forward_id is null or isfirstforward to determind whether is firstforward*/
CREATE TABLE bln_message_forward
(
	_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	comment VARCHAR(128) NOT NULL,
        message_id INTEGER NOT NULL,
        forward_id INTEGER,
        isfirstforward  BOOLEAN,
        operation_transaction_id INTEGER NOT NULL
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
