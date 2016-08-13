<?php

namespace OpenDominion\Tests\Feature;

use Carbon\Carbon;
use CoreDataSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use OpenDominion\Models\Round;
use OpenDominion\Models\RoundLeague;
use OpenDominion\Tests\BaseTestCase;

class RoundTest extends BaseTestCase
{
    use DatabaseMigrations;

    public function testNoMoreThanOneRoundCanBeActiveInALeague()
    {
        $this->markTestIncomplete();
    }

    public function testUserSeesNoActiveDominionsWhenUserDoesntHaveAnyActiveDominions()
    {
        $this->createAndImpersonateUser();

        $this->visit('/dashboard')
            ->see('Dashboard')
            ->see('You have no active dominions');
    }

    public function testUserSeesNoActiveRoundsWhenNoRoundsAreActive()
    {
        $this->createAndImpersonateUser();

        $this->visit('/dashboard')
            ->see('Dashboard')
            ->see('There are currently no active rounds.');
    }

    public function testUserCanSeeActiveRounds()
    {
        $this->seed(CoreDataSeeder::class);
        $this->createAndImpersonateUser();

        Round::create([
            'round_league_id' => RoundLeague::where('key', 'standard')->firstOrFail()->id,
            'number' => 1,
            'name' => 'Testing Round',
            'start_date' => new Carbon('today'),
            'end_date' => new Carbon('+50 days'),
        ]);

        $this->visit('/dashboard')
            ->see('Dashboard')
            ->seeElement('tr', ['class' => 'warning'])
            ->see('Testing Round')
            ->see('(Standard League)')
            ->see('Started!')
            ->see('50 days')
            ->see('Register')
            ->seeInElement('a', 'Register');
    }

    public function testUserCanSeeRoundWhichStartSoon()
    {
        $this->seed(CoreDataSeeder::class);
        $this->createAndImpersonateUser();

        Round::create([
            'round_league_id' => RoundLeague::where('key', 'standard')->firstOrFail()->id,
            'number' => 1,
            'name' => 'Testing Round',
            'start_date' => new Carbon('+3 days'),
            'end_date' => new Carbon('+53 days'),
        ]);

        $this->visit('/dashboard')
            ->see('Dashboard')
            ->seeElement('tr', ['class' => 'success'])
            ->see('Testing Round')
            ->see('(Standard League)')
            ->see('In 3 day(s)')
            ->see('50 days')
            ->seeInElement('a', 'Register');
    }

    public function testUserCanSeeRoundsWhichDontStartSoon()
    {
        $this->seed(CoreDataSeeder::class);
        $this->createAndImpersonateUser();

        Round::create([
            'round_league_id' => RoundLeague::where('key', 'standard')->firstOrFail()->id,
            'number' => 1,
            'name' => 'Testing Round',
            'start_date' => new Carbon('+5 days'),
            'end_date' => new Carbon('+55 days'),
        ]);

        $this->visit('/dashboard')
            ->see('Dashboard')
            ->seeElement('tr', ['class' => 'danger'])
            ->see('Testing Round')
            ->see('(Standard League)')
            ->see('In 5 day(s)')
            ->see('50 days')
            ->see('In 2 day(s)')
            ->dontSeeInElement('a', 'Register');
    }

    public function testUserCanRegisterToARound()
    {
        $this->markTestIncomplete();
    }

    public function testUserCanOnlyRegisterToOneRoundPerALeague()
    {
        $this->markTestIncomplete();
    }

    public function testMultipleUsersCanRegisterToARoundAsAPack()
    {
        $this->markTestIncomplete();
    }

    public function testPacksMustContainUniqueRacesOfSameOrNeutralAlignment()
    {
        $this->markTestIncomplete();
    }

    public function testUserCantPlayYetDuringPreRound()
    {
        $this->markTestIncomplete();
    }

    public function testUserCanBeginPlayingOnceRoundStarts()
    {
        $this->markTestIncomplete();
    }

    // todo: round milestones (prot to d3, early to d16, mid to d33, late to d45, end to d50)
    // todo: post-round stuff
}