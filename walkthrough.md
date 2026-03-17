# MLM Simulation Engine — Walkthrough

## What Was Built

A full `mlm:simulate` Artisan console command that simulates **3 months of MLM activity** with **200 users**, validating ROI, Level Income, and Club rewards.

## Files Created / Modified

| File | Action | Purpose |
|---|---|---|
| [app/Console/Commands/SimulateMLM.php](file:///c:/laravel-projects/mlm/app/Console/Commands/SimulateMLM.php) | **NEW** | Core simulation engine |
| [app/Console/Commands/CheckClubQualification.php](file:///c:/laravel-projects/mlm/app/Console/Commands/CheckClubQualification.php) | **NEW** | Club check command |
| [app/Services/InvestmentService.php](file:///c:/laravel-projects/mlm/app/Services/InvestmentService.php) | Modified | Exposed [distributeBusiness()](file:///c:/laravel-projects/mlm/app/Services/InvestmentService.php#84-112) and [invokeCheckClubQualification()](file:///c:/laravel-projects/mlm/app/Services/InvestmentService.php#113-117) |

## How to Run

```bash
php artisan mlm:simulate --reset
```
> `--reset` truncates all simulation tables, re-seeds settings/levels, and starts fresh.

## Simulation Logic

```
1. Creates 200 users in a balanced binary tree (max ~8 levels)
2. Each user gets a $1,000 investment (ROI = 3% weekly)
3. Loops 90 days:
    - Every day: ROI:distribute (which internally triggers Level Income)
    - Every day: Club:check (checks thresholds, issues vouchers)
4. Prints final summary table
```

> ✅ Level Income is triggered **real-time alongside ROI** (not monthly). Each ROI event immediately distributes commissions to uplines (up to 15 levels).

## Verified Results (Run #1)

| Metric | Value |
|---|---|
| Total Users | 200 |
| Total Investment | **$200,000.00** |
| Total ROI Paid | **$72,000.00** (200 users × $30/week × 12 weeks) ✅ |
| Total Level Income | **$40,748.40** |
| Total Vouchers Issued | 0 (club thresholds require $7k+ direct, $20k+ team) |

### ✅ ROI Verification
- `200 users × $1,000 × 3% × 12 weeks = $72,000` ✅ **Perfect match**

### ✅ Level Income Distribution (Top 10 Earners)

| Rank | Name | Total Earned |
|---|---|---|
| 1 | Root User | $4,406.40 |
| 2 | User 1 | $3,355.20 |
| 3 | User 2 | $2,167.20 |
| 4 | User 3 | $1,972.80 |
| 5 | User 4 | $1,972.80 |
| 6 | User 5 | $1,476.00 |
| 7 | User 6 | $1,281.60 |
| 8 | User 7 | $1,281.60 |
| 9 | User 8 | $1,281.60 |
| 10 | User 9 | $1,281.60 |

Root User (Level 1) earned the most because they receive commissions from all 199 downlines in the tree — exactly as expected in an MLM system.

## Notes

- The simulation was designed to be **idempotent** — run it as many times as needed with `--reset`.
- Club vouchers weren't issued because 200 users × $1,000 investments means the root user gets `direct_business = $2,000` (only 2 direct referrals in a binary tree), which doesn't meet the `$5,000` Star Club threshold. This is **correct** — it reflects real MLM behaviour where top-tier clubs require wide referral networks.
