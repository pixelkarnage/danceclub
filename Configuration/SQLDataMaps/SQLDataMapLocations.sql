#
# These SQL statements maps between the tx_danceclub_domain_model_venue and tx_asfkeventmanagement_locations table
# ====================================================================================================================
INSERT INTO
	tx_danceclub_domain_model_venue (uid, pid, tstamp, crdate, deleted, name, www)
SELECT uid, pid, tstamp, crdate, deleted, location, link FROM tx_asfkeventmanagement_locations;

#
# Set the storage ID to the desired page ID
#
UPDATE
	tx_danceclub_domain_model_venue
SET 
	tx_danceclub_domain_model_venue.pid = 6;

