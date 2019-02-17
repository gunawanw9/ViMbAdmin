<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;

/**
 * Domain
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Domain extends EntityRepository
{
    /**
     * Load for admin
     *
     * Loads domains for given admin. If admin is super it returns
     * all domains.
     *
     * @param \Entities\Admin $admin
     * @return \Entities\Domain[]
     */
    public function loadForAdmin( $admin )
    {
        $dql = "SELECT d FROM \\Entities\\Domain d";
        
        if( !$admin->isSuper() )
            $dql .= " LEFT JOIN d.Admins d2a WHERE d2a = ?1";

        $dql .= " ORDER BY d.domain ASC";
                
        $q = $this->getEntityManager()->createQuery( $dql );
        
        if( !$admin->isSuper() )
            $q->setParameter( 1, $admin );
        
        return $q->execute();
    }

    /**
     * Load as array for admin
     *
     * Its used to get domains names in mailbox add-edit drop down list.
     * It also can be used as loadForDomainList function.
     * It calls loadForDomain iterates thought domains and it can return 
     * two types of arrays: id => name, or id => [ domain data ]
     *
     * @param \Entities\Admin $admin
     * @para bool $onlyNames Type of array if set to true only names will be returned, else all data.
     * @return array
     */
    public function loadForAdminAsArray( $admin, $onlyNames = false )
    {
        $array = [];
        
        if( $onlyNames )
        {
            foreach( $this->loadForAdmin( $admin ) as $domain )
                $array[ $domain->getId() ] = $domain->getDomain();
            
        }
        else
        {
            foreach( $this->loadForAdmin( $admin ) as $domain )
            {
                $array[ $domain->getId() ] = [
                    'domain'        => $domain->getDomain(),
                    'description'   => $domain->getDescription(),
                    'max_aliaseses' => $domain->getMaxAliases(),
                    'alias_count'   => $domain->getAliasesCount(),
                    'max_sender_canonical' => $domain->getMaxCanonical(),
                    'canonical_count'   => $domain->getCanonicalCount(),
                    'max_mailboxes' => $domain->getMaxMailboxes(),
                    'alias_mailbox' => $domain->getMailboxCount(),
                    'max_quota'     => $domain->getMaxQuota(),
                    'quota'         => $domain->getQuota(),
                    'transport'     => $domain->getTransport(),
                    'active'        => $domain->getActive(),
                    'homedir'       => $domain->getHomedir(),
                    'maildir'       => $domain->getMaildir(),
                    'uid'           => $domain->getUid(),
                    'gid'           => $domain->getGid()

                ];
            }
        }
        return $array;
    }
    
    /**
     * Load data for domains list
     *
     * Loads information for domains list.
     *
     * @param \Entities\Admin $admin
     * @return array
     */
    public function loadForDomainList( $admin )
    {
/*    
	    $dql = "SELECT d.id AS id, d.domain AS name, d.alias_count AS aliases, d.mailbox_count AS mailboxes,
                    d.max_aliases AS maxaliases, d.max_mailboxes AS maxmailboxes, SUM( m.maildir_size ) AS mailboxes_size,
                    d.max_quota AS maxquota, d.quota AS quota, d.transport AS transport, d.backupmx AS backupmx,
                    d.active AS active, d.created AS created
		    FROM \\Entities\\Domain d LEFT JOIN d.Mailboxes m";
 */    
	    $dql = "SELECT d.id AS id, d.domain AS name, d.alias_count AS aliases, d.canonical_count AS canonical,
		    d.max_sender_canonical AS maxcanonical, d.mailbox_count AS mailboxes,
                    d.max_aliases AS maxaliases, d.max_mailboxes AS maxmailboxes, SUM( m.maildir_size ) AS mailboxes_size,
                    d.max_quota AS maxquota, d.quota AS quota, d.transport AS transport, d.backupmx AS backupmx,
                    d.active AS active, d.created AS created
                FROM \\Entities\\Domain d LEFT JOIN d.Mailboxes m";
        
        // FIXME a.address != a.goto
        
        if( !$admin->isSuper() )
            $dql .= " LEFT JOIN d.Admins d2a WHERE d2a = ?1";

        $dql .= " GROUP BY d.id ORDER BY d.domain ASC";
                
        $q = $this->getEntityManager()->createQuery( $dql );
        
        if( !$admin->isSuper() )
            $q->setParameter( 1, $admin );

        return $q->getArrayResult();
    }
    
    /**
     * Load data for domains list
     *
     * Loads information for domains list.
     *
     * @param string          $filter 
     * @param \Entities\Admin $admin
     * @return array
     */
    public function filterForDomainList( $filter, $admin )
    {
        $filter = str_replace ( "'" , "" , $filter );
        
        if( strpos( $filter, "*" ) === 0 )
            $filter = '%' . substr( $filter, 1 );

/*	
        $dql = "SELECT d.id AS id, d.domain AS name, d.alias_count AS aliases, d.mailbox_count AS mailboxes,
                    d.max_aliases AS maxaliases, d.max_mailboxes AS maxmailboxes, SUM( m.maildir_size ) AS mailboxes_size,
                    d.max_quota AS maxquota, d.quota AS quota, d.transport AS transport, d.backupmx AS backupmx,
                    d.active AS active, d.created AS created
                FROM \\Entities\\Domain d LEFT JOIN d.Mailboxes m 
                WHERE ( d.domain LIKE '{$filter}%' OR d.transport LIKE '{$filter}%'  OR d.created LIKE '{$filter}%' )";
 */
	$dql = "SELECT d.id AS id, d.domain AS name, d.alias_count AS aliases, d.mailbox_count AS mailboxes,
		d.canonical_count AS canonical, d.max_aliases AS maxaliases, d.max_mailboxes AS maxmailboxes,
		SUM( m.maildir_size ) AS mailboxes_size, d.max_sender_canonical AS maxcanonical,
                d.max_quota AS maxquota, d.quota AS quota, d.transport AS transport, d.backupmx AS backupmx,
                d.active AS active, d.created AS created
                FROM \\Entities\\Domain d LEFT JOIN d.Mailboxes m 
                WHERE ( d.domain LIKE '{$filter}%' OR d.transport LIKE '{$filter}%'  OR d.created LIKE '{$filter}%' )";
        
        if( !$admin->isSuper() )
            $dql .= " LEFT JOIN d.Admins d2a WHERE d2a = ?1";

        $dql .= " GROUP BY d.id ORDER BY d.domain ASC";
                
        $q = $this->getEntityManager()->createQuery( $dql );
        
        if( !$admin->isSuper() )
            $q->setParameter( 1, $admin );

        return $q->getArrayResult();
    }


    /**
     * Convenience function to purge all associations of a domain and the domain
     *
     * @param \Entities\Domain $domain The domain object
     */
    public function purge( $domain )
    {
        $this->purgeMailboxes( $domain );
        $this->purgeAliases( $domain );
        $this->purgeLogs( $domain );
        $this->purgeDomainAdmins( $domain );
        
        $this->getEntityManager()->remove( $domain );
        $this->getEntityManager()->flush();
    }
    
    /**
     * Purge all mailboxes of a domain
     *
     * @param $domain \Entities\Domain The domain to purge the mailboxes of
     * @return int The number of records deleted
     */
    public function purgeMailboxes( $domain )
    {
        return $this->getEntityManager()->createQuery(
                "DELETE FROM \\Entities\\Mailbox m WHERE m.Domain = ?1"
            )
            ->setParameter( 1, $domain )
            ->execute();
    }
    
    /**
     * Purge all canonical of a domain
     *
     * @param $domain \Entities\Domain The domain to purge the aliases of
     * @return int The number of records deleted
     */
    public function purgeCanonical( $domain )
    {
        return $this->getEntityManager()->createQuery(
                "DELETE FROM \\Entities\\Canonical m WHERE m.Domain = ?1"
            )
            ->setParameter( 1, $domain )
            ->execute();
    }
    
    /**
     * Purge all alaises of a domain
     *
     * @param $domain \Entities\Domain The domain to purge the aliases of
     * @return int The number of records deleted
     */
    public function purgeAliases( $domain )
    {
        return $this->getEntityManager()->createQuery(
                "DELETE FROM \\Entities\\Alias m WHERE m.Domain = ?1"
            )
            ->setParameter( 1, $domain )
            ->execute();
    }
    
    /**
     * Purge all logs of a domain
     *
     * @param $domain \Entities\Domain The domain to purge the logs of
     * @return int The number of logs deleted
     */
    public function purgeLogs( $domain )
    {
        return $this->getEntityManager()->createQuery(
                "DELETE FROM \\Entities\\Log m WHERE m.Domain = ?1"
            )
            ->setParameter( 1, $domain )
            ->execute();
    }
    
    /**
     * Purge all links to admins for a domain
     *
     * Requires a flush()
     *
     * @param $domain \Entities\Domain The domain to purge the admin links of
     * @return int The number of links deleted
     */
    public function purgeDomainAdmins( $domain )
    {
        foreach( $domain->getAdmins() as $a )
            $domain->removeAdmin( $a );
    }

    /**
     * Finds all domains which are not assigned with admin.
     * 
     * Finds all domains and iterate through then making an array of 'id' => 'domain'
     * If domain inactive domain name will be append by '(inactive)' then we iterate
     * through admin domains and removing all array elements which id is already in admin domains list.
     *
     * @param \Entities\Admin $admin Admin to look for not assign domains
     * @retun array
     */
    public function getNotAssignedForAdmin( $admin )
    {
        $domainNames = [];
        foreach( $this->findAll() as $domain )
            $domainNames[ $domain->getId() ] = $domain->getActive() ? $domain->getDomain() : $domain->getDomain() . " (inactive)";

        foreach( $admin->getDomains() as $domain )
            if( isset( $domainNames[ $domain->getId() ] ) )
                unset( $domainNames[ $domain->getId() ] );
        
        return $domainNames;
    }
    
}
