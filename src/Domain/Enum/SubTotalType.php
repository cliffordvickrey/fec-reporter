<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Enum;

use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractEnum;

final class SubTotalType extends AbstractEnum
{
    public const SUB_TYPE_ONE_DOLLAR = 'oneDollar';
    public const SUB_TYPE_ONE_TO_TWO_HUNDRED_DOLLARS = 'oneToTwoHundredDollars';
    public const SUB_TYPE_TWO_HUNDRED_TO_ONE_THOUSAND_DOLLARS = 'twoHundredToOneThousandDollars';
    public const SUB_TYPE_ONE_THOUSAND_TO_TWENTY_EIGHT_HUNDRED_DOLLARS = 'oneThousandToTwentyEightHundredDollars';
    public const SUB_TYPE_TWENTY_EIGHT_HUNDRED_DOLLARS = 'twentyEightHundredDollars';
    public const SUB_TYPE_FULL_2020_PRIMARY_CYCLE = 'full2020PrimaryCycle';
    public const SUB_TYPE_PRE_2019 = 'pre2019';
    public const SUB_TYPE_Q1_2019 = 'q12019';
    public const SUB_TYPE_Q2_2019 = 'q22019';
    public const SUB_TYPE_Q3_2019 = 'q32019';
    public const SUB_TYPE_Q4_2019 = 'q42019';
    public const SUB_TYPE_Q1_2020 = 'q12020';
    public const SUB_TYPE_DEBATE1 = 'debate1';
    public const SUB_TYPE_DEBATE2 = 'debate2';
    public const SUB_TYPE_DEBATE3 = 'debate3';
    public const SUB_TYPE_DEBATE4 = 'debate4';
    public const SUB_TYPE_DEBATE5 = 'debate5';
    public const SUB_TYPE_DEBATE6 = 'debate6';
    public const SUB_TYPE_DEBATE7 = 'debate7';
    public const SUB_TYPE_OUT_OF_STATE = 'outOfState';
    public const SUB_TYPE_IN_STATE = 'inState';
    public const SUB_TYPE_PRIOR = 'prior';
    public const SUB_TYPE_LOYAL = 'loyal';
    public const SUB_TYPE_DONOR_2016 = 'donor2016';
    public const SUB_TYPE_CLINTON_2016 = 'clinton2016';
    public const SUB_TYPE_SANDERS_2016 = 'sanders2016';
    public const SUB_TYPE_OBAMA_2012 = 'obama2012';
    public const SUB_TYPE_TRAITOR = 'traitor';
    public const SUB_TYPE_ELITE = 'elite';
    public const SUB_TYPE_PARTY = 'party';
    public const SUB_TYPE_NATIONAL_PARTY = 'nationalParty';
    public const SUB_TYPE_STATE_PARTY = 'stateParty';
    public const SUB_TYPE_LOCAL_PARTY = 'localParty';
    public const SUB_TYPE_COMPETITOR_ENDORSEMENT = 'competitorEndorsement';
    public const SUB_TYPE_CONGRESSIONAL_ENDORSEMENT = 'congressionalEndorsement';
    public const SUB_TYPE_SENATE_ENDORSEMENT = 'senateEndorsement';
    public const SUB_TYPE_HOUSE_ENDORSEMENT = 'houseEndorsement';

    /**
     * @return array<string, string>
     */
    protected function getEnum(): array
    {
        return [
            self::SUB_TYPE_ONE_DOLLAR => '$1 Donors',
            self::SUB_TYPE_ONE_TO_TWO_HUNDRED_DOLLARS => '$1.01-$199.99 Donors',
            self::SUB_TYPE_TWO_HUNDRED_TO_ONE_THOUSAND_DOLLARS => '$200-$999.999 Donors',
            self::SUB_TYPE_ONE_THOUSAND_TO_TWENTY_EIGHT_HUNDRED_DOLLARS => '$1000-$2799.99 Donors',
            self::SUB_TYPE_TWENTY_EIGHT_HUNDRED_DOLLARS => '$2800 Donors',
            self::SUB_TYPE_FULL_2020_PRIMARY_CYCLE => 'Full 2020 Primary Cycle: November 6, 2016 - April 24, 2020',
            self::SUB_TYPE_PRE_2019 => 'Pre 2019',
            self::SUB_TYPE_Q1_2019 => '2019 Quarter 1 (January 1 - March 31)',
            self::SUB_TYPE_Q2_2019 => '2019 Quarter 2 (April 1 - June 30)',
            self::SUB_TYPE_Q3_2019 => '2019 Quarter 3 (July 1 - September 30)',
            self::SUB_TYPE_Q4_2019 => '2019 Quarter 4 (October 1 - December 31)',
            self::SUB_TYPE_Q1_2020 => '2020 Quarter 1 (January 1 - March 31)',
            self::SUB_TYPE_DEBATE1 => 'Debate 1 (January 1, 2019 - June 12, 2019)',
            self::SUB_TYPE_DEBATE2 => 'Debate 2 (June 13, 2019 - July 16, 2019)',
            self::SUB_TYPE_DEBATE3 => 'Debate 3 (July 17, 2019 - August 28, 2019)',
            self::SUB_TYPE_DEBATE4 => 'Debate 4 (August 29, 2019 - October 1, 2019)',
            self::SUB_TYPE_DEBATE5 => 'Debate 5 (October 2, 2019 - November 13, 2019)',
            self::SUB_TYPE_DEBATE6 => 'Debate 6 (November 14, 2019 - December 13, 2019)',
            self::SUB_TYPE_DEBATE7 => 'Debate 7 (December 14, 2019 - January 11, 2020)',
            self::SUB_TYPE_OUT_OF_STATE => 'Out-of-State (Donors from different state as candidate)',
            self::SUB_TYPE_IN_STATE => 'In-State (Donors from same state as candidate)',
            self::SUB_TYPE_PRIOR => 'Prior Donors',
            self::SUB_TYPE_LOYAL => 'Loyal Donors',
            self::SUB_TYPE_DONOR_2016 => '2016 Democratic Presidential Donors',
            self::SUB_TYPE_CLINTON_2016 => 'Clinton Donors',
            self::SUB_TYPE_SANDERS_2016 => 'Sanders Donors',
            self::SUB_TYPE_OBAMA_2012 => 'Obama 2012 Donors',
            self::SUB_TYPE_TRAITOR => 'Traitorous Donors (Donors who gave to Trump in 2020)',
            self::SUB_TYPE_ELITE => 'Elite Donors',
            self::SUB_TYPE_PARTY => 'Party Committee Donors',
            self::SUB_TYPE_NATIONAL_PARTY => 'National Party Committee Donors',
            self::SUB_TYPE_STATE_PARTY => 'State Party Committee Donors',
            self::SUB_TYPE_LOCAL_PARTY => 'Local Party Committee Donors',
            self::SUB_TYPE_COMPETITOR_ENDORSEMENT => 'Competitor Endorsement Donors (Donors who gave to other'
                . ' presidential endorser)',
            self::SUB_TYPE_CONGRESSIONAL_ENDORSEMENT => 'Congressional Endorsement Donors (Donors who gave an endoser'
                . ' in Congress)',
            self::SUB_TYPE_SENATE_ENDORSEMENT => 'Senate Endorsement Donors (Donors who gave to Senate endorser)',
            self::SUB_TYPE_HOUSE_ENDORSEMENT => 'House Endorsement Donors (Donors who gave to House endorser)'
        ];
    }
}
