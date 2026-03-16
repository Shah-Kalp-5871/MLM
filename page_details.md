Below is a **clear page-by-page specification** for your current Laravel view structure.
Goal: **Each page = simple module + list + create + edit + view where needed.**
No theme/UI suggestions — only **what data and actions each page contains**.

You can add this to **`projectlogic.md` under "Page Specifications"**.

---

# 1. AUTH PAGES

## `/auth/login.blade.php`

### Purpose

User or admin login.

### Fields

* Email
* Password

### Buttons

* Login
* Forgot Password (optional)

### Logic

1. Validate credentials
2. Check role
3. Redirect:

   * Admin → `/admin/dashboard`
   * User → `/user/dashboard`

---

## `/auth/register.blade.php`

### Purpose

User registration.

### Fields

* Name
* Email
* Phone
* Password
* Confirm Password
* Referral Code

### Actions

* Create user
* Generate referral code
* Set `upline_id`

### Redirect

```
Login Page
```

---

# 2. USER PANEL

---

# `/user/dashboard.blade.php`

### Purpose

Main user overview.

### Widgets

* Total Investment
* Wallet Balance
* Total ROI Earned
* Total Level Income
* Direct Referrals Count
* Team Size
* Club Progress

### Data Sources

* investments
* wallets
* roi_incomes
* level_commissions
* referrals

### Additional Sections

Recent Transactions

| Type | Amount | Date |
| ---- | ------ | ---- |

Recent ROI

| Week | ROI |
| ---- | --- |

---

# `/user/investments/index.blade.php`

### Purpose

Manage user investments.

### Table

| ID | Package | Amount | ROI % | Status | Start Date | End Date |
| -- | ------- | ------ | ----- | ------ | ---------- | -------- |

### Buttons

* **New Investment**
* **View**
* **Cancel** (optional)

---

## `/user/investments/create.blade.php` (NEW PAGE)

### Fields

* Select Package
* Amount
* Payment Method
* Upload Payment Proof

### Action

Create deposit request.

---

# `/user/wallet/index.blade.php`

### Purpose

Show wallet balance and transactions.

### Wallet Summary

* Balance
* Total Earned
* Total Withdrawn

### Transactions Table

| ID | Type | Amount | Description | Date |
| -- | ---- | ------ | ----------- | ---- |

Transaction types

```
ROI Income
Level Income
Deposit
Withdrawal
Voucher
```

---

# `/user/withdrawals/index.blade.php`

### Purpose

Withdrawal requests.

### Table

| ID | Amount | Payment Method | Status | Date |
| -- | ------ | -------------- | ------ | ---- |

### Buttons

* **Request Withdrawal**

---

## `/user/withdrawals/create.blade.php` (NEW PAGE)

### Fields

* Amount
* Payment Method
* Wallet Address / Bank

### Validation

Check wallet balance.

---

# `/user/referrals/index.blade.php`

### Purpose

User referral information.

### Sections

#### Referral Link

```
https://site.com/register?ref=CODE
```

#### Direct Referrals Table

| User | Joined Date | Investment |
| ---- | ----------- | ---------- |

---

# `/user/network/index.blade.php`

### Purpose

Display MLM tree.

### Data

Tree Structure

```
You
 ├ User A
 │   └ User C
 └ User B
```

### Table View

| User | Level | Investment | Join Date |
| ---- | ----- | ---------- | --------- |

---

# `/user/roi/index.blade.php`

### Purpose

Show ROI income.

### Table

| Week | Investment | ROI % | ROI Amount | Date |
| ---- | ---------- | ----- | ---------- | ---- |

### Summary

* Total ROI Earned

---

# `/user/level-income/index.blade.php`

### Purpose

Level commissions.

### Table

| From User | Level | ROI Ref | Commission | Date |
| --------- | ----- | ------- | ---------- | ---- |

### Summary

* Total Level Income

---

# `/user/club-rewards/index.blade.php`

### Purpose

Show club progress.

### Section

Progress

| Metric          | Value |
| --------------- | ----- |
| Direct Business | $XXXX |
| Team Business   | $XXXX |

### Qualification Table

| Level | Direct Business | Team Business | Reward |
| ----- | --------------- | ------------- | ------ |

### Earned Rewards

| Reward | Voucher Code | Status |
| ------ | ------------ | ------ |

---

# `/user/profile/index.blade.php`

### Purpose

User account management.

### Fields

* Name
* Email
* Phone
* Address
* Wallet Address
* Password Change

### Buttons

* Update Profile
* Change Password

---

# 3. ADMIN PANEL

---

# `/admin/dashboard/index.blade.php`

### Purpose

System overview.

### Stats

* Total Users
* Active Users
* Total Deposits
* Total Withdrawals
* Total ROI Paid
* Total Level Income

### Charts (data)

* User Growth
* Weekly ROI Distribution
* Deposits vs Withdrawals

### Recent Activity

| Action | User | Date |
| ------ | ---- | ---- |

---

# `/admin/users/index.blade.php`

### Purpose

Manage users.

### Table

| ID | Name | Email | Upline | Status | Joined |
| -- | ---- | ----- | ------ | ------ | ------ |

### Buttons

* View
* Edit
* Block
* View Network

---

## `/admin/users/create.blade.php` (NEW)

Fields

* Name
* Email
* Phone
* Password
* Referral Code

---

## `/admin/users/edit.blade.php`

Edit user info.

---

# `/admin/deposits/index.blade.php`

### Purpose

Manage deposits.

### Table

| ID | User | Amount | Method | Status | Date |
| -- | ---- | ------ | ------ | ------ | ---- |

### Buttons

* Approve
* Reject
* View Proof

---

# `/admin/withdrawals/index.blade.php`

### Purpose

Process withdrawals.

### Table

| ID | User | Amount | Method | Status | Date |
| -- | ---- | ------ | ------ | ------ | ---- |

### Buttons

* Approve
* Reject
* Mark Paid

---

# `/admin/roi/index.blade.php`

### Purpose

Track ROI distributions.

### Table

| ID | User | Investment | ROI Amount | Week | Date |
| -- | ---- | ---------- | ---------- | ---- | ---- |

### Buttons

* Run ROI Distribution

---

# `/admin/level-income/index.blade.php`

### Purpose

View network commissions.

### Table

| Receiver | From User | Level | Amount | Date |
| -------- | --------- | ----- | ------ | ---- |

---

# `/admin/network/index.blade.php`

### Purpose

View MLM structure.

### Views

Tree

```
User A
 ├ B
 └ C
```

Table

| User | Upline | Level | Team Size |

---

# `/admin/club/index.blade.php`

### Purpose

Club qualification management.

### Table

| User | Direct Business | Team Business | Club Level |
| ---- | --------------- | ------------- | ---------- |

### Buttons

* Approve Reward

---

# `/admin/vouchers/index.blade.php`

### Purpose

Voucher management.

### Table

| Code | Value | Assigned To | Status |
| ---- | ----- | ----------- | ------ |

### Buttons

* Create Voucher
* Assign Voucher

---

## `/admin/vouchers/create.blade.php`

Fields

* Voucher Value
* Code
* Expiry

---

# `/admin/reports/index.blade.php`

### Purpose

System reports.

### Sections

User Reports

| Total Users | Active Users |

Financial Reports

| Total Deposits | Withdrawals |

Network Reports

| Top Referrers |

---

# FINAL PAGE COUNT

### User Pages

```
Dashboard
Investments
Wallet
Withdrawals
Referrals
Network
ROI
Level Income
Club Rewards
Profile
```

Total ≈ **10 pages**

---

### Admin Pages

```
Dashboard
Users
Deposits
Withdrawals
ROI
Level Income
Network
Club
Vouchers
Reports
```

Total ≈ **10 pages**

---

# TOTAL PROJECT PAGES

```
~25 pages including create/edit pages
```

---

If you want, I can also show you something **extremely useful for your Laravel MLM project**:

I can generate the **complete Laravel route structure + controller methods for all these pages**, so you can implement the **entire system 10x faster.**


Below is a **clear “Page Content Checklist”** for your current folder structure.
Each page lists **exactly what sections, fields, tables, and actions it contains**.
This is **module-style**: every page has **List / Create / Edit / View / Actions** where applicable.

---

# AUTH PAGES

## auth/login.blade.php

### Sections

* Login Form

### Fields

* Email
* Password

### Actions

* Login
* Redirect based on role

---

## auth/register.blade.php

### Sections

* Registration Form

### Fields

* Name
* Email
* Phone
* Password
* Confirm Password
* Referral Code

### Actions

* Create Account
* Generate Referral Code
* Set Upline

---

# USER PANEL

---

# user/dashboard.blade.php

### Sections

Account Summary

* Total Investment
* Wallet Balance
* Total ROI Earned
* Total Level Income

Network Summary

* Direct Referrals
* Team Size
* Club Level

Recent Activity

Tables

Recent Transactions

| Type | Amount | Date |

Recent ROI

| Week | ROI | Date |

Recent Level Income

| From User | Level | Amount |

---

# user/investments/index.blade.php

### Sections

Investment Summary

* Total Investment
* Active Investments
* Expired Investments

### Table

| ID | Package | Amount | ROI % | Status | Start Date | End Date |

### Actions

* Create Investment
* View Investment

---

## user/investments/create.blade.php

### Fields

* Select Package
* Amount
* Payment Method
* Upload Payment Proof

### Actions

* Submit Deposit Request

---

# user/wallet/index.blade.php

### Sections

Wallet Summary

* Wallet Balance
* Total Earnings
* Total Withdrawn

### Table

| ID | Type | Amount | Description | Date |

Types

* ROI Income
* Level Income
* Deposit
* Withdrawal
* Voucher

---

# user/withdrawals/index.blade.php

### Sections

Withdrawal Summary

* Total Withdrawn
* Pending Withdrawals

### Table

| ID | Amount | Method | Status | Date |

### Actions

* Request Withdrawal

---

## user/withdrawals/create.blade.php

### Fields

* Withdrawal Amount
* Payment Method
* Wallet Address / Bank Details

### Actions

* Submit Withdrawal Request

---

# user/referrals/index.blade.php

### Sections

Referral Link

* Display Personal Referral Link
* Copy Button

Referral Stats

* Total Direct Referrals
* Total Team Members

### Table

Direct Referrals

| User | Email | Join Date | Investment |

---

# user/network/index.blade.php

### Sections

Network Summary

* Team Size
* Total Team Investment

### Views

Tree View

Example

You
├ User A
│ └ User C
└ User B

Table View

| User | Upline | Level | Investment | Join Date |

---

# user/roi/index.blade.php

### Sections

ROI Summary

* Total ROI Earned

### Table

| Week | Investment | ROI % | ROI Amount | Date |

---

# user/level-income/index.blade.php

### Sections

Income Summary

* Total Level Income

### Table

| From User | Level | ROI Reference | Commission | Date |

---

# user/club-rewards/index.blade.php

### Sections

Club Progress

| Metric          | Value  |
| --------------- | ------ |
| Direct Business | amount |
| Team Business   | amount |

Qualification Table

| Level | Direct Business | Team Business | Reward |

Earned Rewards

| Reward | Voucher Code | Status |

---

# user/profile/index.blade.php

### Sections

Profile Information

Fields

* Name
* Email
* Phone
* Address
* Wallet Address

Security

Fields

* Current Password
* New Password
* Confirm Password

### Actions

* Update Profile
* Change Password

---

# ADMIN PANEL

---

# admin/dashboard/index.blade.php

### Sections

Platform Statistics

* Total Users
* Active Users
* Total Deposits
* Total Withdrawals
* Total ROI Paid
* Total Level Commissions

Financial Summary

* Total Investment
* Total Profit Distribution

Recent Activity

| Action | User | Date |

Recent Deposits

| User | Amount | Status |

Recent Withdrawals

| User | Amount | Status |

---

# admin/users/index.blade.php

### Sections

User Statistics

* Total Users
* Active Users
* Blocked Users

### Table

| ID | Name | Email | Upline | Status | Join Date |

### Actions

* View User
* Edit User
* Block User
* View Network

---

## admin/users/create.blade.php

Fields

* Name
* Email
* Phone
* Password
* Referral Code

---

## admin/users/edit.blade.php

Fields

* Name
* Email
* Phone
* Status

Actions

* Update User

---

# admin/deposits/index.blade.php

### Sections

Deposit Summary

* Total Deposits
* Pending Deposits

### Table

| ID | User | Amount | Payment Method | Status | Date |

### Actions

* Approve Deposit
* Reject Deposit
* View Payment Proof

---

# admin/withdrawals/index.blade.php

### Sections

Withdrawal Summary

* Total Withdrawals
* Pending Withdrawals

### Table

| ID | User | Amount | Method | Status | Date |

### Actions

* Approve Withdrawal
* Reject Withdrawal
* Mark Paid

---

# admin/roi/index.blade.php

### Sections

ROI Summary

* Total ROI Distributed

### Table

| ID | User | Investment | ROI Amount | Week | Date |

### Actions

* Run ROI Distribution
* View ROI History

---

# admin/level-income/index.blade.php

### Sections

Commission Summary

* Total Level Income Paid

### Table

| Receiver | From User | Level | Commission | Date |

---

# admin/network/index.blade.php

### Sections

Network Statistics

* Total Network Members

Views

Tree View

Example

User A
├ User B
└ User C

Table View

| User | Upline | Level | Team Size |

---

# admin/club/index.blade.php

### Sections

Club Qualification Summary

### Table

| User | Direct Business | Team Business | Club Level |

### Actions

* Approve Reward
* Issue Voucher

---

# admin/vouchers/index.blade.php

### Sections

Voucher Summary

* Total Vouchers
* Used Vouchers

### Table

| Code | Value | Assigned User | Status |

### Actions

* Create Voucher
* Assign Voucher
* View Voucher

---

## admin/vouchers/create.blade.php

Fields

* Voucher Code
* Value
* Expiry Date

Actions

* Create Voucher

---

# admin/reports/index.blade.php

### Sections

User Reports

* Total Users
* User Growth

Financial Reports

* Total Deposits
* Total Withdrawals
* ROI Paid

Network Reports

* Top Referrers
* Largest Teams

Tables

Top Earners

| User | Earnings |

Top Referrers

| User | Referrals |

---

# TOTAL PAGE MODULES

User Panel Pages

* Dashboard
* Investments
* Wallet
* Withdrawals
* Referrals
* Network
* ROI
* Level Income
* Club Rewards
* Profile

Admin Panel Pages

* Dashboard
* Users
* Deposits
* Withdrawals
* ROI
* Level Income
* Network
* Club
* Vouchers
* Reports

---

If you want, I can also create a **very useful developer document next**:

**“API / Controller Method Map”**

It will show:

* which controller method powers each page
* which database tables each page uses
* what queries run on each page

This makes **Laravel implementation extremely fast.**
