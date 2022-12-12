<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Enum;

use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractEnum;

use function str_replace;
use function strtolower;

final class TotalType extends AbstractEnum
{
    public const TYPE_ALL = 'all';
    public const TYPE_DAY_ONE_LAUNCH = 'dayOneLaunch';
    public const TYPE_WEEK_ONE_LAUNCH = 'weekOneLaunch';
    public const TYPE_FIRST_TIME = 'firstTime';
    public const TYPE_PRIOR = 'prior';
    public const TYPE_PRIOR_CAMPAIGN = 'priorCampaign';
    public const TYPE_PRIOR_LEADERSHIP_PAC = 'priorLeadershipPac';
    public const TYPE_ENDORSEMENT = 'endorsement';
    public const TYPE_ENDORSEMENT_PRE = 'endorsementPre';
    public const TYPE_ENDORSEMENT_POST = 'endorsementPost';
    public const TYPE_CONGRESSIONAL_ENDORSEMENT = 'congressionalEndorsement';
    public const TYPE_COMPETITOR_ENDORSEMENT = 'competitorEndorsement';
    public const TYPE_NON_ENDORSEMENT = 'nonEndorsement';
    public const TYPE_UNFAITHFUL = 'unfaithful';
    public const TYPE_LOYAL = 'loyal';
    public const TYPE_DONOR_2016 = 'donor2016';
    public const TYPE_CLINTON_2016 = 'clinton2016';
    public const TYPE_SANDERS_2016 = 'sanders2016';
    public const TYPE_ELITE = 'elite';
    public const TYPE_ELITE_PARTY = 'eliteParty';
    public const TYPE_ELITE_PAC = 'elitePac';

    /** @var array<non-empty-string, non-empty-string> */
    private static array $blurbs = [
        self::TYPE_ALL => 'All donors who gave before 4/25/2020',
        self::TYPE_DAY_ONE_LAUNCH => 'Donors who contributed on day 1',
        self::TYPE_WEEK_ONE_LAUNCH => 'Donors who contributed in week 1',
        self::TYPE_FIRST_TIME => 'Donors who only gave to presidential campaign committee and made no contributions to'
            . ' any other committee in 2020 or any other election',
        self::TYPE_PRIOR => 'Donors who gave to one of the candidate\'s other campaign committees or their previous'
            . ' leadership PAC before contributing to their presidential campaign committee',
        self::TYPE_PRIOR_CAMPAIGN => 'Donors who gave to one of the candidate\'s other campaign committees before'
            . ' contributing to their presidential campaign committee',
        self::TYPE_PRIOR_LEADERSHIP_PAC => 'Donors who gave to candidate\'s leadership PAC before contributing to their'
            . ' presidential campaign committee',
        self::TYPE_ENDORSEMENT => 'Donors who gave to an endorser\'s campaign committee or leadership PAC',
        self::TYPE_ENDORSEMENT_PRE => 'Donors gave to an endorser\'s campaign committee or leadership PAC before'
            . 'their endorsement data',
        self::TYPE_ENDORSEMENT_POST => 'Donors gave to an endorser\'s campaign committee or leadership PAC on or after'
            . 'their endorsement data',
        self::TYPE_COMPETITOR_ENDORSEMENT => 'Donors to gave to an endorsing presidential candidate\'s campaign'
            . ' committee or leadership PAC',
        self::TYPE_CONGRESSIONAL_ENDORSEMENT => 'Donors to gave to an endorsing Member of Congress\' campaign committee'
            . ' or leadership PAC',
        self::TYPE_NON_ENDORSEMENT => 'Donors who did not give to an endorser\'s campaign committee or leadership PAC',
        self::TYPE_UNFAITHFUL => 'Donors who gave to a presidential candidate committee in 2020 and some other'
            . ' Democratic presidential candidate committee in 2020',
        self::TYPE_LOYAL => 'Donors who gave only to one presidential candidate committee in 2020',
        self::TYPE_DONOR_2016 => 'Donors who gave to a Democratic presidential campaign committee 2016',
        self::TYPE_CLINTON_2016 => 'Donors who gave to Clinton campaign committee in 2016',
        self::TYPE_SANDERS_2016 => 'Donors who gave to Sanders campaign committee in 2016',
        self::TYPE_ELITE => 'Gave to candidate campaign committee in 2020 and National/State/County Political Party or'
            . ' PAC in 2020 or before',
        self::TYPE_ELITE_PARTY => 'Gave to candidate campaign committee in 2020 and National/State/County Political'
            . ' Party in 2020 or before',
        self::TYPE_ELITE_PAC => 'Gave to candidate campaign committee in 2020 and PAC in 2020 or before'
    ];

    /**
     * @return non-empty-string
     */
    public function getBlurb(): string
    {
        return self::$blurbs[$this->getValue()];
    }

    /**
     * @return string
     */
    public function getDownloadDescription(): string
    {
        return str_replace(
            ['clinton', 'sanders', 'pac'],
            ['Clinton', 'Sanders', 'PAC'],
            strtolower($this->getDescription())
        );
    }

    /**
     * @inheritDoc
     */
    protected function getEnum(): array
    {
        return [
            self::TYPE_ALL => 'Primary Donors',
            self::TYPE_DAY_ONE_LAUNCH => 'Day 1 Launch Donors',
            self::TYPE_WEEK_ONE_LAUNCH => 'Week 1 Launch Donors',
            self::TYPE_FIRST_TIME => 'First-Time Donors',
            self::TYPE_PRIOR => 'Prior Donors',
            self::TYPE_PRIOR_CAMPAIGN => 'Prior Campaign Donors',
            self::TYPE_PRIOR_LEADERSHIP_PAC => 'Prior Leadership PAC Donors',
            self::TYPE_ENDORSEMENT => 'Endorsement Donors',
            self::TYPE_ENDORSEMENT_PRE => 'Endorsement Donors (Pre)',
            self::TYPE_ENDORSEMENT_POST => 'Endorsement Donors (Post)',
            self::TYPE_COMPETITOR_ENDORSEMENT => 'Competitor Endorsement Donors',
            self::TYPE_CONGRESSIONAL_ENDORSEMENT => 'Congressional Endorsement Donors',
            self::TYPE_NON_ENDORSEMENT => 'Non-Endorsement Donors',
            self::TYPE_UNFAITHFUL => 'Unfaithful Donors',
            self::TYPE_LOYAL => 'Loyal Donors',
            self::TYPE_DONOR_2016 => '2016 Donors',
            self::TYPE_CLINTON_2016 => 'Clinton Donors',
            self::TYPE_SANDERS_2016 => 'Sanders Donors',
            self::TYPE_ELITE => 'Elite Donors',
            self::TYPE_ELITE_PARTY => 'Elite Party Donors',
            self::TYPE_ELITE_PAC => 'Elite PAC Donors'
        ];
    }
}
