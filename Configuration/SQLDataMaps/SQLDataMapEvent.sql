#
# DB MAP TO THE NEW SYSTEM
# =============

# Set reoccurrance_until
ALTER TABLE tx_asfkeventmanagement_events ADD tx_asfkeventmanagement_events.reoccurrance_until int(11) DEFAULT '-1';

UPDATE tx_asfkeventmanagement_events
SET tx_asfkeventmanagement_events.reoccurrance_until = tx_asfkeventmanagement_events.eventend
WHERE tx_asfkeventmanagement_events.frequency > '0';

# Set frequency
ALTER TABLE `tx_asfkeventmanagement_events` CHANGE `frequency` `frequency` VARCHAR(255) NOT NULL;

# copy the data into 
INSERT INTO tx_danceclub_domain_model_event (uid, pid, name, description, price, teachers, types, venues, event_groups, tstamp, crdate, cruser_id, deleted, calendarize)
SELECT uid, pid, title, description, tx_ttlogon_price, tx_ttlogon_staff, type, location, tx_ttlogon_plantsession, tstamp, crdate, cruser_id, deleted, uid 
FROM tx_asfkeventmanagement_events;

# Set the storage ID to the desired page ID
UPDATE tx_danceclub_domain_model_event
SET tx_danceclub_domain_model_event.pid = 19;

# handle frequency correction
UPDATE tx_asfkeventmanagement_events
SET tx_asfkeventmanagement_events.frequency = 'yearly' #monthly
WHERE tx_asfkeventmanagement_events.frequency = '3'; 

UPDATE tx_asfkeventmanagement_events
SET tx_asfkeventmanagement_events.frequency = 'monthly' #monthly
WHERE tx_asfkeventmanagement_events.frequency = '2'; 

UPDATE tx_asfkeventmanagement_events
SET tx_asfkeventmanagement_events.frequency = 'weekly' #weekly
WHERE tx_asfkeventmanagement_events.frequency = '1';

UPDATE tx_asfkeventmanagement_events
SET tx_asfkeventmanagement_events.frequency = '' #none
WHERE tx_asfkeventmanagement_events.frequency = '0';

#copy the calendar info into tx_calendarize_domain_model_configuration
INSERT INTO tx_calendarize_domain_model_configuration ( uid, pid, tstamp, crdate, cruser_id, deleted, hidden, starttime, endtime, start_date, end_date, start_time, end_time, frequency, till_date)
SELECT 	uid, pid, tstamp, crdate, cruser_id, deleted, hidden, starttime, endtime, eventbegin, eventend, timebegin, timeend, frequency, reoccurrance_until
FROM tx_asfkeventmanagement_events;

# handle the "is bookable" question, by adding the link if it isn't categroy special or milonga or practica
UPDATE tx_danceclub_domain_model_event
SET tx_danceclub_domain_model_event.bookable = '1' 
WHERE (tx_danceclub_domain_model_event.types IN(3,4,5,6,7,9));


# Handle TYPE MM
# the types field in the local table = a count of relations
# the uid_local field = the uid of the event
# the uid_foreign field = type uid
# since we only have, until now, 1 type per event we only map it over

INSERT INTO tx_danceclub_event_type_mm (uid_local, uid_foreign, sorting)
SELECT uid, types, '1'
FROM tx_danceclub_domain_model_event
WHERE 1;

# set the count
UPDATE tx_danceclub_domain_model_event
SET types = '1'
WHERE 1;

DELETE FROM `tx_danceclub_event_type_mm` WHERE `uid_foreign` = 0;

# SAME PROCEDURE FOR VENUES
INSERT INTO tx_danceclub_event_venue_mm (uid_local, uid_foreign, sorting)
SELECT uid, venues, '1'
FROM tx_danceclub_domain_model_event
WHERE 1;

# set the count
UPDATE tx_danceclub_domain_model_event
SET venues = '1'
WHERE 1;

INSERT INTO `tx_danceclub_domain_model_venue` (`uid`, `pid`, `tstamp`, `crdate`, `cruser_id`, `deleted`, `name`, `www`) VALUES
(1, 353, 1292770881, 1213822543, 1, 0, 'Caminito', ''),
(2, 353, 1292770914, 1213822651, 1, 0, 'Dachstock, Sommer Casino', ''),
(3, 353, 1292770914, 1213825309, 1, 0, 'Worldshop, Union', ''),
(4, 353, 1292770914, 1215361184, 1, 0, 'Clarahof', ''),
(6, 353, 1292770914, 1215502106, 2, 0, 'Pavillon Claramatte', ''),
(7, 353, 1275513491, 1234792125, 1, 0, 'Grosser Saal, Union', ''),
(8, 353, 1275513491, 1243788145, 1, 0, 'Italien', ''),
(9, 353, 1456329983, 1243789439, 1, 0, 'Schweiz', ''),
(10, 353, 1275513491, 1243789450, 1, 0, 'Deutschland', ''),
(11, 353, 1275513491, 1243789471, 1, 0, 'Frankreich', ''),
(12, 353, 1275513491, 1243789487, 1, 0, 'Spanien', ''),
(13, 353, 1275643346, 1275643346, 1, 0, 'Corrientes', ''),
(14, 353, 1275643373, 1275643373, 1, 0, 'Gundeldinger Feld', ''),
(15, 309, 1284209625, 1284209625, 1, 0, 'Zirkusschule', ''),
(16, 353, 1333271815, 1333271815, 1, 0, 'Theaterfalle', ''),
(18, 353, 1333277589, 1333277589, 1, 0, 'Mittlere Brücke, Helvetiastatue', 'http://g.co/maps/9tuzd'),
(19, 353, 1456330271, 1347697759, 1, 0, 'Rigi', 'Rigi'),
(20, 353, 1396507143, 1396507143, 1, 0, 'SpielFeld', 'http://www.robi-spiel-aktionen.ch/'),
(21, 422, 1445273163, 1418849120, 1, 0, 'Walkringen', ''),
(24, 400, 1456335379, 1456335379, 10, 0, 'Rigi', ''),
(22, 353, 1456330086, 1456330086, 10, 0, 'Rigi', ''),
(23, 353, 1456330163, 1456330163, 10, 0, 'Rigi', '');

# SAME PROCEDURE FOR EVENT GROUP
INSERT INTO tx_danceclub_event_eventgroup_mm (uid_local, uid_foreign, sorting)
SELECT uid, event_groups, '1'
FROM tx_danceclub_domain_model_event
WHERE 1;

# set the count
UPDATE tx_danceclub_domain_model_event
SET event_groups = '1'
WHERE 1;

# For the Teachers field there already is a mm table so copy it over
INSERT INTO tx_danceclub_event_frontenduser_mm (uid_local, uid_foreign, sorting)
SELECT uid_local, uid_foreign, sorting
FROM tx_asfkeventmanagement_events_tx_ttlogon_staff_mm
WHERE 1;

# However since we want to clean the fe_user base to only teachers we shall map the uid foreign to the new value
# also: run these one at a time
UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 1
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 2;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 22
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 6;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 2
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 30;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 6
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 31;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 4
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 56;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 9
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 58;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 23
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 67;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 3
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 70;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 19
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 131;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 24
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 134;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 25
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 135;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 10
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 149;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 15
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 152;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 5
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 167;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 26
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 203;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 27
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 225;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 13
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 230;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 28
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 253;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 29
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 269;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 7
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 271

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 8
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 272;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 30
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 273;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 16
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 277;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 3
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 278;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 14
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 303;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 32
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 302;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 33
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 301;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 34
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 299;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 35
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 298;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 11
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 297;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 12
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 296;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 18
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 295;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 17
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 289;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 36
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 288;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 37
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 287;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 38
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 286;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 39
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 285;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 40
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 284;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 41
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 283;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 42
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 282;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 21
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 281;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 43
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 280;

UPDATE tx_danceclub_event_frontenduser_mm
SET tx_danceclub_event_frontenduser_mm.uid_foreign = 44
WHERE tx_danceclub_event_frontenduser_mm.uid_foreign = 279;


# DEPRECATED
# Then MAP over from fe_users_2
INSERT INTO fe_users (uid, pid, tstamp, username, password, name, first_name, middle_name, last_name, address, telephone, email, crdate, deleted, zip, city, country, www)
SELECT uid, pid, tstamp, username, password, name, first_name, middle_name, last_name, address, telephone, email, crdate, deleted, zip, city, country, www
FROM fe_users_2
WHERE fe_users_2.uid IN ( 
     SELECT GROUP_CONCAT(DISTINCT(tx_asfkeventmanagement_events_tx_ttlogon_staff_mm.uid_foreign)) 
     FROM tx_asfkeventmanagement_events_tx_ttlogon_staff_mm 
     WHERE 1
     GROUP BY tx_asfkeventmanagement_events_tx_ttlogon_staff_mm.uid_foreign);
# set storage 
UPDATE fe_users
SET fe_users.pid = 4;