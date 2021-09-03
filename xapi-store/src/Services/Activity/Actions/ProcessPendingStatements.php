<?php

namespace Trax\XapiStore\Services\Activity\Actions;

use Illuminate\Support\Collection;

trait ProcessPendingStatements
{
    use RecordStatementsActivities;
    
    /**
     * Process the pending statements.
     *
     * @param  \Illuminate\Support\Collection  $statements
     * @param  boolean  $allowPseudonymization
     * @return void
     */
    public function processPendingStatements(Collection $statements, bool $allowPseudonymization): void
    {
        if (config('trax-xapi-store.queues.activities.enabled', false)) {
            $this->startProcessingJob($statements);
        } else {
            $this->processStatementsNow($statements, $allowPseudonymization);
        }
    }

    /**
     * Start a processing job.
     *
     * @param  \Illuminate\Support\Collection  $statements
     * @return void
     */
    protected function startProcessingJob(Collection $statements): void
    {
    }

    /**
     * Process a batch of statements.
     *
     * @param  \Illuminate\Support\Collection  $statements
     * @param  boolean  $allowPseudonymization
     * @return void
     */
    protected function processStatementsNow(Collection $statements, bool $allowPseudonymization): void
    {
        $this->recordStatementsActivities($statements);

        // Skip the agent and verb services if we are not in a relational model.
        if (config('trax-xapi-store.requests.relational', false)) {
            app(\Trax\XapiStore\Services\Agent\AgentService::class)
                ->processPendingStatements($statements, $allowPseudonymization);
        } else {
            app(\Trax\XapiStore\Services\StatementRecord\StatementRecordService::class)
                ->processPendingStatements($statements, $allowPseudonymization);
        }
    }
}
