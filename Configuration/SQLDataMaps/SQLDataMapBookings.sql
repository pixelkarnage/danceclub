
CREATE TABLE db2.table LIKE db1.table;
INSERT INTO db2.table SELECT * FROM db1.table;

# 
# This SQL stores all fe_user_2 data on the tx_ttlogon_registrations table
# ======================================================================
CREATE TEMPORARY TABLE booking_tmp
SELECT tx_ttlogon_registrations.uid, GROUP_CONCAT(fe_users_2.name) AS name, GROUP_CONCAT(fe_users_2.email) AS email
FROM tx_ttlogon_registrations 
INNER JOIN (fe_users_2) 
ON (tx_ttlogon_registrations.feuserid=fe_users_2.uid)
GROUP BY tx_ttlogon_registrations.uid;

#
# This SQL copys all user Data that was selectet into the tx_ttlogon_registrations table
# 
UPDATE tx_ttlogon_registrations, booking_tmp
SET tx_ttlogon_registrations.name = booking_tmp.name, tx_ttlogon_registrations.email = booking_tmp.email
WHERE booking_tmp.uid = tx_ttlogon_registrations.uid;


#
# Group the bookings eventid if more that 1 booking happened
# ==========================================================

CREATE TEMPORARY TABLE booking_temp
SELECT  tx_ttlogon_registrations.uid, tx_asfkeventmanagement_events.tx_ttlogon_plantsession AS event_group
FROM tx_ttlogon_registrations
INNER JOIN tx_asfkeventmanagement_events
ON tx_asfkeventmanagement_events.uid=tx_ttlogon_registrations.eventid;

#
# This SQL copys all program Data that was selectet into the tx_ttlogon_registrations table
# 
ALTER TABLE tx_ttlogon_registrations ADD tx_ttlogon_registrations.event_group int(11) DEFAULT '0';
UPDATE tx_ttlogon_registrations, booking_temp
SET tx_ttlogon_registrations.event_group = booking_temp.event_group
WHERE booking_temp.uid = tx_ttlogon_registrations.uid;


ALTER TABLE tx_ttlogon_registrations ADD tx_ttlogon_registrations.amount int(11) DEFAULT '0';
UPDATE tx_ttlogon_registrations, tx_asfkeventmanagement_events
SET tx_ttlogon_registrations.amount = tx_asfkeventmanagement_events.tx_ttlogon_price
WHERE tx_ttlogon_registrations.eventid = tx_asfkeventmanagement_events.uid;

#==============================================================
#
#
#
# RUN SCRIPT!
#
#
#
#
#

#
# Change the Dance-Style to the new format
# LEAD: 1 = same FOLLOW: was 0 is now 2!
UPDATE tx_ttlogon_registrations
SET tx_ttlogon_registrations.style = 2
WHERE tx_ttlogon_registrations.style = 0;


#
# Copy all Data
INSERT INTO tx_danceclub_domain_model_booking (uid, pid, name, email, dance_style, student, amount, tstamp, crdate, deleted)
SELECT uid, pid, name, email, style, student, amount, tstamp, crdate, deleted 
FROM tx_ttlogon_registrations;

INSERT INTO tx_danceclub_booking_event_mm (uid_local, uid_foreign)
SELECT uid, eventid
FROM tx_ttlogon_registrations;

#
# Set the storage ID to the desired page ID
UPDATE tx_danceclub_domain_model_booking
SET tx_danceclub_domain_model_booking.pid = 20;