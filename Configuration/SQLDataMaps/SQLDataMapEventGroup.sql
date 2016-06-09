#
# This SQL maps information between the tables tx_ttlogon_sessions and tx_danceclub_domain_model_eventgroup
# ================================================================================================================

#
# Copy all Data
# Remove show_page_instead and link if you dont need that data.
#
INSERT INTO tx_danceclub_domain_model_eventgroup (uid, pid, title, subtitle, description, activate_booking, tstamp, crdate, deleted)
SELECT uid, pid, title, subtitle, text, active, tstamp, crdate, deleted 
FROM tx_ttlogon_sessions;

#
# Set the storage ID to the desired page ID
UPDATE tx_danceclub_domain_model_eventgroup
SET tx_danceclub_domain_model_eventgroup.pid = 6;

#
# Create MM relations to events
INSERT INTO tx_danceclub_eventgroup_event_mm (uid_foreign, uid_local)
SELECT uid AS uid_foreign, tx_ttlogon_plantsession AS uid_local
FROM tx_asfkeventmanagement_events 
WHERE tx_ttlogon_plantsession != 0;
