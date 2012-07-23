INSERT INTO bln_servicetype (typename,description) VALUES ('personal_service_type','Personal Service Type');
INSERT INTO bln_servicetype (typename,description) VALUES ('normal_service_type','Normal Service Type');

/* add some teamtype*/
INSERT INTO bln_serviceteamtype (teamtype,profile) VALUES ('work_team_type','WorkTeam Type');
INSERT INTO bln_serviceteamtype (teamtype,profile) VALUES ('served_team_type','ServedTeam Type');
INSERT INTO bln_serviceteamtype (teamtype,profile) VALUES ('friend_team_type','FriendTeam Type');

/* add some application*/

/*
INSERT INTO bln_application (appname,classname,showable) VALUES ('BServiceEngine','BServiceEngine',false);
INSERT INTO bln_application (appname,classname,showable) VALUES ('BPersonalMessage','BPersonalMessageApp',true);
INSERT INTO bln_application (appname,classname,showable) VALUES ('BilynAdmin','BilynAdminApp',true);
*/

/* add roletype*/
INSERT INTO bln_authitem_type (typename) VALUES ('workteam_admin');
INSERT INTO bln_authitem_type (typename) VALUES ('workteam_member');
INSERT INTO bln_authitem_type (typename) VALUES ('servedteam_admin');
INSERT INTO bln_authitem_type (typename) VALUES ('servedteam_member');
INSERT INTO bln_authitem_type (typename) VALUES ('service_mixed');
INSERT INTO bln_authitem_type (typename) VALUES ('service_none');

INSERT INTO bln_service_scopetype (scopename) VALUES ('service_scope');
INSERT INTO bln_service_scopetype (scopename) VALUES ('servicetype_scope');
INSERT INTO bln_service_scopetype (scopename) VALUES ('servicecategory_scope');


INSERT INTO bln_servicecategory (categoryname) VALUES ('business');
INSERT INTO bln_servicecategory (categoryname) VALUES ('public-service');
INSERT INTO bln_servicecategory (categoryname) VALUES ('unit-internal');
INSERT INTO bln_servicecategory (categoryname) VALUES ('unknown');


/* add role for serviceengine*/
/*
INSERT INTO bln_application_authitem (app_id,authname,authtype) VALUES (1,'serviceengine_serviceadmin',5);
INSERT INTO bln_application_authitem (app_id,authname,authtype) VALUES (1,'serviceengine_workteamadmin',1);
INSERT INTO bln_application_authitem (app_id,authname,authtype) VALUES (1,'serviceengine_workteammember',2);
INSERT INTO bln_application_authitem (app_id,authname,authtype) VALUES (1,'serviceengine_servedteamadmin',3);
INSERT INTO bln_application_authitem (app_id,authname,authtype) VALUES (1,'serviceengine_servedteammember',4);
INSERT INTO bln_application_authitem (app_id,authname,authtype) VALUES (1,'serviceengine_servicemember',6);
*/