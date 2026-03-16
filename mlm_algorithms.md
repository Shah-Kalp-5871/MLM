Below is a **developer-level section** you can add to your `projectlogic.md` or a separate file like `mlm_algorithms.md`.
This explains **how ROI and Level Income should actually be calculated in Laravel**, including **database logic, cron jobs, and pseudocode**.

---

# ROI + Level Income Calculation Logic

This section explains how the system calculates:

1. **ROI Income**
2. **Level Commission Income**

These processes run **automatically using Laravel Scheduler / Cron Jobs**.

---

# 1. ROI Income Calculation Logic

## Purpose

ROI (Return on Investment) is **weekly profit distributed to users based on their active investment amount**.

Example from compensation plan:

| Investment | Weekly ROI |
| ---------- | ---------- |
| $500       | 3% – 3.5%  |

Example calculation:

```
ROI = Investment × ROI Percentage
```

Example:

```
$500 × 3% = $15
```

---

# 2. Required Database Tables

### users

```
id
name
email
referral_code
upline_id
created_at
```

---

### investments

Stores user deposits.

```
id
user_id
amount
roi_percentage
roi_start_date
status
created_at
```

Example:

| user_id | amount | roi |
| ------- | ------ | --- |
| 5       | 500    | 3   |

---

### wallets

Stores user balances.

```
id
user_id
balance
created_at
```

---

### wallet_transactions

Tracks wallet activity.

```
id
user_id
type
amount
source
reference_id
created_at
```

Example:

| type       | amount | source     |
| ---------- | ------ | ---------- |
| roi_income | 15     | investment |

---

# 3. Weekly ROI Cron Job

ROI is distributed **once per week**.

Laravel scheduler example:

```php
$schedule->command('roi:distribute')->weekly();
```

---

# 4. ROI Distribution Algorithm

Step-by-step logic.

### Step 1

Find all **active investments**

```php
$investments = Investment::where('status', 'active')->get();
```

---

### Step 2

Loop through each investment

```php
foreach ($investments as $investment)
```

---

### Step 3

Calculate ROI

```php
$roi = $investment->amount * ($investment->roi_percentage / 100);
```

Example:

```
500 × 3% = 15
```

---

### Step 4

Add ROI to user wallet

```php
Wallet::where('user_id', $investment->user_id)
      ->increment('balance', $roi);
```

---

### Step 5

Store wallet transaction

```php
WalletTransaction::create([
    'user_id' => $investment->user_id,
    'type' => 'roi_income',
    'amount' => $roi,
    'source' => 'roi',
    'reference_id' => $investment->id
]);
```

---

### Step 6

Trigger Level Commission Distribution

```php
$this->distributeLevelCommission($investment->user_id, $roi);
```

---

# 5. Level Income Logic

Level income is earned **when a downline user receives ROI**.

Commission is calculated **from the ROI amount**, not the deposit.

Example:

User B earns ROI:

```
$15
```

Level 1 commission:

```
20%
```

User A earns:

```
$3
```

---

# 6. Level Commission Table

Example commission structure:

```php
$levelPercentages = [
1 => 20,
2 => 12,
3 => 9,
4 => 6,
5 => 6,
6 => 6,
7 => 4,
8 => 4,
9 => 4,
10 => 4,
11 => 2,
12 => 2,
13 => 2,
14 => 2,
15 => 2
];
```

---

# 7. Level Commission Algorithm

### Step 1

Start from the user who received ROI.

```
current_user = ROI receiver
```

---

### Step 2

Find the **upline**

```php
$upline = User::find($user->upline_id);
```

---

### Step 3

Calculate commission

Example:

```
ROI = $15
Level 1 commission = 20%
```

Calculation:

```
15 × 20% = $3
```

---

### Step 4

Add commission to upline wallet

```php
Wallet::where('user_id', $upline->id)
      ->increment('balance', $commission);
```

---

### Step 5

Save transaction

```php
WalletTransaction::create([
'user_id' => $upline->id,
'type' => 'level_income',
'amount' => $commission,
'source' => 'level_'.$level,
'reference_id' => $downlineUserId
]);
```

---

# 8. Complete Level Commission Function (Pseudo Code)

Example Laravel function.

```php
function distributeLevelCommission($userId, $roiAmount)
{
    $levelPercentages = [
        1 => 20,
        2 => 12,
        3 => 9,
        4 => 6,
        5 => 6,
        6 => 6,
        7 => 4,
        8 => 4,
        9 => 4,
        10 => 4,
        11 => 2,
        12 => 2,
        13 => 2,
        14 => 2,
        15 => 2
    ];

    $currentUser = User::find($userId);

    for ($level = 1; $level <= 15; $level++) {

        $upline = User::find($currentUser->upline_id);

        if (!$upline) {
            break;
        }

        $percentage = $levelPercentages[$level];

        $commission = $roiAmount * ($percentage / 100);

        Wallet::where('user_id', $upline->id)
              ->increment('balance', $commission);

        WalletTransaction::create([
            'user_id' => $upline->id,
            'type' => 'level_income',
            'amount' => $commission,
            'source' => 'level_'.$level,
            'reference_id' => $userId
        ]);

        $currentUser = $upline;
    }
}
```

---

# 9. Multi-Level Example

Network:

```
A → B → C → D
```

Investment:

```
$500 each
```

Weekly ROI:

```
$15 each
```

Level commissions:

```
Level 1 = 20%
Level 2 = 12%
Level 3 = 9%
```

Income for A:

From B:

```
15 × 20% = $3
```

From C:

```
15 × 12% = $1.8
```

From D:

```
15 × 9% = $1.35
```

Total weekly level income:

```
$6.15
```

---

# 10. Full ROI + Level Flow

Complete process:

```
Cron Job Runs
      ↓
Find Active Investments
      ↓
Calculate Weekly ROI
      ↓
Add ROI to Wallet
      ↓
Trigger Level Commission
      ↓
Distribute Commission to 15 Levels
      ↓
Store Transactions
```

---

# 11. Important Edge Cases

The system must handle these situations.

---

### Case 1

User has **no upline**

Result:

```
Level commission stops
```

---

### Case 2

Upline account is inactive.

Possible options:

1. Skip upline
2. Give commission anyway
3. Stop distribution

(Admin decision)

---

### Case 3

User has multiple investments.

Solution:

```
ROI calculated per investment
```

---

### Case 4

User withdraws wallet.

ROI and level income continue normally.

---

# 12. Performance Optimization

Since MLM networks can be large:

Use:

* **Database indexing**
* **Queue jobs**
* **Batch processing**

Example:

```
ROI job → queue
Level distribution → queue
```

This prevents server overload.

---
