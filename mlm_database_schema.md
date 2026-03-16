Below is a **clean, normalized, and detailed database schema** for your **Laravel MLM project**.
Goal of this design:

* **Every major feature has its own table**
* **Admin and Users separated**
* **Easy to maintain**
* **Clear relationships**
* **Scalable MLM structure**

You can put this in a file like **`mlm_database_schema.md`**.

---

# MLM Database Schema

This schema supports the following modules:

* User Management
* Admin Management
* Referral System
* MLM Network Tree
* Investment / Deposits
* ROI Distribution
* Level Commission Distribution
* Wallet System
* Withdrawals
* Club Qualification
* Voucher Rewards
* Transaction History
* Reports

---

# 1. Admin Table

Admins are **separate from users**.

### `admins`

| Column     | Type      | Description         |
| ---------- | --------- | ------------------- |
| id         | bigint    | Primary key         |
| name       | varchar   | Admin name          |
| email      | varchar   | Login email         |
| password   | varchar   | Hashed password     |
| role       | varchar   | super_admin / staff |
| status     | boolean   | active / disabled   |
| last_login | timestamp | last login          |
| created_at | timestamp |                     |
| updated_at | timestamp |                     |

Example

```
id: 1
name: Super Admin
email: admin@mlm.com
```

---

# 2. Users Table

Stores all MLM users.

### `users`

| Column        | Type      | Description          |
| ------------- | --------- | -------------------- |
| id            | bigint    | Primary key          |
| name          | varchar   | User name            |
| email         | varchar   | Email                |
| phone         | varchar   | Phone number         |
| password      | varchar   | Password             |
| referral_code | varchar   | Unique referral code |
| upline_id     | bigint    | Parent user          |
| status        | boolean   | active / blocked     |
| joined_at     | timestamp | registration time    |
| created_at    | timestamp |                      |
| updated_at    | timestamp |                      |

Example

```
A → refers B → refers C
```

```
B.upline_id = A.id
C.upline_id = B.id
```

---

# 3. User Profiles Table

Additional user details stored separately.

### `user_profiles`

| Column         | Type      | Description  |
| -------------- | --------- | ------------ |
| id             | bigint    |              |
| user_id        | bigint    | reference    |
| address        | text      | user address |
| city           | varchar   |              |
| country        | varchar   |              |
| profile_image  | varchar   |              |
| wallet_address | varchar   | crypto/bank  |
| created_at     | timestamp |              |

---

# 4. Referral Links Table

Stores referral tracking.

### `referrals`

| Column           | Type      | Description      |
| ---------------- | --------- | ---------------- |
| id               | bigint    |                  |
| referrer_id      | bigint    | user who invited |
| referred_user_id | bigint    | new user         |
| level            | int       | level depth      |
| created_at       | timestamp |                  |

Example

```
A refers B
B refers C
C refers D
```

Records created.

---

# 5. MLM Tree Table

Stores the **hierarchical network**.

### `mlm_tree`

| Column        | Type   | Description   |
| ------------- | ------ | ------------- |
| id            | bigint |               |
| ancestor_id   | bigint | parent user   |
| descendant_id | bigint | child user    |
| level         | int    | network level |

Example

```
A → B → C → D
```

Records

```
A,B,1
A,C,2
A,D,3
B,C,1
B,D,2
C,D,1
```

This allows **fast team business calculation**.

---

# 6. Investment Packages Table

Different investment plans.

### `packages`

| Column             | Type      |
| ------------------ | --------- |
| id                 | bigint    |
| name               | varchar   |
| price              | decimal   |
| roi_percentage     | decimal   |
| roi_duration_weeks | int       |
| status             | boolean   |
| created_at         | timestamp |

Example

```
Starter = $500
ROI = 3%
```

---

# 7. User Investments Table

Stores user deposits.

### `investments`

| Column         | Type      |
| -------------- | --------- |
| id             | bigint    |
| user_id        | bigint    |
| package_id     | bigint    |
| amount         | decimal   |
| roi_percentage | decimal   |
| roi_start_date | date      |
| roi_end_date   | date      |
| status         | varchar   |
| created_at     | timestamp |

Status

```
pending
active
expired
```

---

# 8. Deposits Table

Tracks payment records.

### `deposits`

| Column         | Type      |
| -------------- | --------- |
| id             | bigint    |
| user_id        | bigint    |
| amount         | decimal   |
| payment_method | varchar   |
| payment_proof  | varchar   |
| status         | varchar   |
| approved_by    | bigint    |
| approved_at    | timestamp |
| created_at     | timestamp |

Status

```
pending
approved
rejected
```

---

# 9. ROI Income Table

Tracks ROI generated.

### `roi_incomes`

| Column         | Type      |
| -------------- | --------- |
| id             | bigint    |
| user_id        | bigint    |
| investment_id  | bigint    |
| roi_amount     | decimal   |
| roi_percentage | decimal   |
| week_number    | int       |
| distributed_at | timestamp |

Example

```
investment = $500
ROI = $15
week = 1
```

---

# 10. Level Commission Table

Tracks MLM commissions.

### `level_commissions`

| Column            | Type      |
| ----------------- | --------- |
| id                | bigint    |
| receiver_id       | bigint    |
| from_user_id      | bigint    |
| level             | int       |
| roi_reference_id  | bigint    |
| commission_amount | decimal   |
| created_at        | timestamp |

Example

```
User B ROI = $15
User A commission = $3
```

---

# 11. Wallet Table

Stores **user balance**.

### `wallets`

| Column     | Type      |
| ---------- | --------- |
| id         | bigint    |
| user_id    | bigint    |
| balance    | decimal   |
| created_at | timestamp |
| updated_at | timestamp |

---

# 12. Wallet Transactions Table

Every wallet movement recorded.

### `wallet_transactions`

| Column       | Type      |
| ------------ | --------- |
| id           | bigint    |
| user_id      | bigint    |
| type         | varchar   |
| amount       | decimal   |
| reference_id | bigint    |
| description  | text      |
| created_at   | timestamp |

Transaction types

```
roi_income
level_income
deposit
withdrawal
voucher_redeem
```

---

# 13. Withdrawals Table

Tracks withdrawal requests.

### `withdrawals`

| Column         | Type      |
| -------------- | --------- |
| id             | bigint    |
| user_id        | bigint    |
| amount         | decimal   |
| payment_method | varchar   |
| wallet_address | varchar   |
| status         | varchar   |
| approved_by    | bigint    |
| approved_at    | timestamp |
| created_at     | timestamp |

Status

```
pending
approved
rejected
paid
```

---

# 14. Club Qualification Table

Tracks club progress.

### `club_qualifications`

| Column          | Type      |
| --------------- | --------- |
| id              | bigint    |
| user_id         | bigint    |
| direct_business | decimal   |
| team_business   | decimal   |
| qualified_level | int       |
| updated_at      | timestamp |

---

# 15. Club Rewards Table

Stores earned rewards.

### `club_rewards`

| Column        | Type      |
| ------------- | --------- |
| id            | bigint    |
| user_id       | bigint    |
| level         | int       |
| reward_amount | decimal   |
| reward_type   | varchar   |
| status        | varchar   |
| created_at    | timestamp |

Example

```
Level 2 reward = $1000 voucher
```

---

# 16. Voucher Table

Voucher codes for club rewards.

### `vouchers`

| Column     | Type      |
| ---------- | --------- |
| id         | bigint    |
| code       | varchar   |
| value      | decimal   |
| status     | varchar   |
| created_at | timestamp |

Status

```
unused
redeemed
expired
```

---

# 17. Voucher Assignment Table

Tracks voucher ownership.

### `voucher_assignments`

| Column      | Type      |
| ----------- | --------- |
| id          | bigint    |
| voucher_id  | bigint    |
| user_id     | bigint    |
| assigned_at | timestamp |

---

# 18. Voucher Redemption Table

Tracks usage.

### `voucher_redemptions`

| Column      | Type      |
| ----------- | --------- |
| id          | bigint    |
| voucher_id  | bigint    |
| user_id     | bigint    |
| order_id    | bigint    |
| redeemed_at | timestamp |

---

# 19. Activity Logs Table

Tracks system actions.

### `activity_logs`

| Column      | Type      |
| ----------- | --------- |
| id          | bigint    |
| user_id     | bigint    |
| action      | varchar   |
| description | text      |
| created_at  | timestamp |

Example

```
User created investment
User requested withdrawal
```

---

# 20. System Settings Table

Stores platform configuration.

### `settings`

| Column     | Type      |
| ---------- | --------- |
| id         | bigint    |
| key        | varchar   |
| value      | text      |
| created_at | timestamp |

Examples

```
roi_percentage
withdrawal_fee
min_withdrawal
```

---

# 21. Level Commission Configuration

### `level_settings`

| Column     | Type    |
| ---------- | ------- |
| id         | bigint  |
| level      | int     |
| percentage | decimal |

Example

| Level | Commission |
| ----- | ---------- |
| 1     | 20         |
| 2     | 12         |
| 3     | 9          |
| 4     | 6          |
| 5     | 6          |

Up to 15.

---

# 22. ROI Settings Table

### `roi_settings`

| Column                 | Type    |
| ---------------------- | ------- |
| id                     | bigint  |
| min_roi                | decimal |
| max_roi                | decimal |
| distribution_frequency | varchar |

Example

```
min_roi = 3
max_roi = 3.5
frequency = weekly
```

---

# 23. Reports Table (Optional)

### `reports`

| Column       | Type      |
| ------------ | --------- |
| id           | bigint    |
| report_type  | varchar   |
| generated_by | bigint    |
| generated_at | timestamp |

---

# 24. Database Relationship Overview

```
Users
 ├── User Profiles
 ├── Referrals
 ├── MLM Tree
 ├── Investments
 │      └── ROI Incomes
 ├── Wallet
 │      └── Wallet Transactions
 ├── Withdrawals
 ├── Level Commissions
 ├── Club Qualifications
 ├── Club Rewards
 │      └── Vouchers
 └── Activity Logs
```

---

# 25. Total Tables

This schema contains approximately:

```
22 Tables
```

Including:

```
Admin tables
User tables
MLM network tables
Income tables
Wallet tables
Voucher tables
System tables
```

---

