Below is a **clean and scalable Laravel folder structure** for your **MLM (Multi Level Marketing) project**.
This structure is designed so your project stays **organized, maintainable, and production-ready**.

I will divide it into:

1️⃣ **Standard Laravel Structure**
2️⃣ **MLM Business Logic Structure**
3️⃣ **Admin Panel Structure**
4️⃣ **User Panel Structure**
5️⃣ **Services / Algorithms (ROI + Level Income)**
6️⃣ **Cron Jobs / Schedulers**

---

# 1. Root Project Structure

```
mlm-platform/
│
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── vendor/
│
├── projectlogic.md
├── mlm_database_schema.md
├── mlm_algorithms.md
│
├── .env
├── composer.json
└── artisan
```

Your **documentation files**

```
projectlogic.md
mlm_database_schema.md
mlm_algorithms.md
```

help developers understand the system.

---

# 2. App Folder Structure (Core Logic)

```
app/
│
├── Console/
│   └── Commands/
│       ├── DistributeROI.php
│       ├── DistributeLevelIncome.php
│       └── CheckClubQualification.php
│
├── Http/
│   ├── Controllers/
│   │
│   ├── Middleware/
│   │
│   └── Requests/
│
├── Models/
│
├── Services/
│
├── Repositories/
│
├── Helpers/
│
└── Traits/
```

---

# 3. Controllers Structure

Controllers separated by **Admin and User**.

```
app/Http/Controllers/
│
├── Auth/
│   ├── LoginController.php
│   └── RegisterController.php
│
├── User/
│   ├── DashboardController.php
│   ├── InvestmentController.php
│   ├── WalletController.php
│   ├── WithdrawalController.php
│   ├── ReferralController.php
│   ├── NetworkController.php
│   ├── ROIController.php
│   ├── LevelIncomeController.php
│   ├── ClubRewardController.php
│   └── ProfileController.php
│
└── Admin/
    ├── DashboardController.php
    ├── UserController.php
    ├── DepositController.php
    ├── WithdrawalController.php
    ├── ROIController.php
    ├── LevelCommissionController.php
    ├── NetworkController.php
    ├── ClubController.php
    ├── VoucherController.php
    └── ReportController.php
```

---

# 4. Models Structure

```
app/Models/
│
├── User.php
├── Investment.php
├── Wallet.php
├── WalletTransaction.php
├── Withdrawal.php
├── Deposit.php
├── Referral.php
├── LevelCommission.php
├── ROIIncome.php
├── ClubReward.php
├── Voucher.php
└── VoucherRedemption.php
```

---

# 5. Services (Business Logic)

All **MLM algorithms should go here**.

```
app/Services/
│
├── ROIService.php
├── LevelIncomeService.php
├── ReferralService.php
├── TeamBusinessService.php
├── DirectBusinessService.php
├── ClubQualificationService.php
├── VoucherService.php
└── WalletService.php
```

Example responsibilities:

| Service                  | Purpose                     |
| ------------------------ | --------------------------- |
| ROIService               | calculate weekly ROI        |
| LevelIncomeService       | distribute level commission |
| ReferralService          | manage referral logic       |
| TeamBusinessService      | calculate team volume       |
| ClubQualificationService | check reward eligibility    |
| WalletService            | manage wallet operations    |

---

# 6. Repositories (Database Logic)

Optional but good practice.

```
app/Repositories/
│
├── UserRepository.php
├── InvestmentRepository.php
├── WalletRepository.php
├── ReferralRepository.php
└── TransactionRepository.php
```

---

# 7. Console Commands (Cron Jobs)

```
app/Console/Commands/
│
├── DistributeROI.php
├── DistributeLevelCommission.php
└── CheckClubQualification.php
```

Example scheduler:

```
app/Console/Kernel.php
```

```
$schedule->command('roi:distribute')->weekly();
$schedule->command('level:distribute')->weekly();
$schedule->command('club:check')->daily();
```

---

# 8. Routes Structure

```
routes/
│
├── web.php
├── api.php
├── admin.php
└── user.php
```

Example:

```
routes/admin.php
routes/user.php
```

---

# 9. Database Structure

```
database/
│
├── migrations/
│
├── seeders/
│
└── factories/
```

Example migrations:

```
create_users_table.php
create_investments_table.php
create_wallets_table.php
create_wallet_transactions_table.php
create_withdrawals_table.php
create_vouchers_table.php
create_level_commissions_table.php
create_roi_incomes_table.php
create_club_rewards_table.php
```

---

# 10. Views (Frontend UI)

```
resources/views/
│
├── layouts/
│
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
│
├── user/
│   ├── dashboard.blade.php
│   ├── investments/
│   ├── wallet/
│   ├── withdrawals/
│   ├── referrals/
│   ├── network/
│   ├── roi/
│   ├── level-income/
│   ├── club-rewards/
│   └── profile/
│
└── admin/
    ├── dashboard/
    ├── users/
    ├── deposits/
    ├── withdrawals/
    ├── roi/
    ├── level-income/
    ├── network/
    ├── club/
    ├── vouchers/
    └── reports/
```

---

# 11. Public Assets

```
public/
│
├── css/
├── js/
├── images/
└── uploads/
```

Uploads include:

```
payment proofs
profile images
documents
```

---

# 12. Storage Folder

```
storage/
│
├── app/
│
├── logs/
│
└── framework/
```

Used for:

```
logs
file uploads
cache
sessions
```

---

# 13. Config Files

```
config/
│
├── mlm.php
├── wallet.php
├── roi.php
└── levels.php
```

Example:

```
config/levels.php
```

```
return [
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

# 14. Clean Architecture Diagram

```
Controller
   ↓
Service
   ↓
Repository
   ↓
Model
   ↓
Database
```

Example:

```
ROIController
     ↓
ROIService
     ↓
InvestmentRepository
     ↓
Investment Model
     ↓
Database
```

---

# 15. Final Clean Architecture

```
mlm-platform
│
├── Controllers
├── Services
├── Repositories
├── Models
├── Console Commands
├── Routes
├── Views
└── Database
```

This structure ensures:

✅ scalable MLM system
✅ easy debugging
✅ clean code separation
✅ faster development

---

