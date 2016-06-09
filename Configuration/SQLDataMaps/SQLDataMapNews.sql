# Matching Fields:
# // tt_news
# `uid`, `pid`, `tstamp`, `crdate`, `cruser_id`, `t3ver_oid`, `t3ver_id`, `t3ver_wsid`, `t3ver_label`, `t3ver_state`, `t3ver_stage`, `t3ver_count`, `t3ver_tstamp`, `t3_origuid`, `editlock`, `deleted`, `hidden`, `starttime`, `endtime`, `fe_group`, `title`, `short`, `bodytext`, `datetime`, `related`,  `author`, `author_email`, `category`, `type`, `keywords`, `ext_url`, `sys_language_uid`, `l18n_parent`, `l18n_diffsource`, 
# // tx_news_domain_model_news
# `uid`, `pid`, `tstamp`, `crdate`, `cruser_id`, `t3ver_oid`, `t3ver_id`, `t3ver_wsid`, `t3ver_label`, `t3ver_state`, `t3ver_stage`, `t3ver_count`, `t3ver_tstamp`, `t3_origuid`, `editlock`, `deleted`, `hidden`, `starttime`, `endtime`, `fe_group`, `title`, `teaser`, `bodytext`, `datetime`, `related`, `author`, `author_email`, `categories`, `type`, `keywords`, `externalurl`, `sys_language_uid`, `l10n_parent`, `l10n_diffsource`

# Results in the following SQL:

INSERT INTO tx_news_domain_model_news (`uid`, `pid`, `tstamp`, `crdate`, `cruser_id`, `t3ver_oid`, `t3ver_id`, `t3ver_wsid`, `t3ver_label`, `t3ver_state`, `t3ver_stage`, `t3ver_count`, `t3ver_tstamp`, `t3_origuid`, `editlock`, `deleted`, `hidden`, `starttime`, `endtime`, `fe_group`, `title`, `teaser`, `bodytext`, `datetime`, `related`, `author`, `author_email`, `type`, `keywords`, `externalurl`, `sys_language_uid`, `l10n_parent`, `l10n_diffsource`)
SELECT `uid`, `pid`, `tstamp`, `crdate`, `cruser_id`, `t3ver_oid`, `t3ver_id`, `t3ver_wsid`, `t3ver_label`, `t3ver_state`, `t3ver_stage`, `t3ver_count`, `t3ver_tstamp`, `t3_origuid`, `editlock`, `deleted`, `hidden`, `starttime`, `endtime`, `fe_group`, `title`, `short`, `bodytext`, `datetime`, `related`,  `author`, `author_email`, `type`, `keywords`, `ext_url`, `sys_language_uid`, `l18n_parent`, `l18n_diffsource` 
FROM tt_news;

#
# Set the storage ID to the desired page ID
#
UPDATE
	tx_news_domain_model_news
SET 
	tx_news_domain_model_news.pid = 7;

#
# The Categories and MM-Relations
#

