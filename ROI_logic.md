Perfect! Let’s design a **complete plan for Weekly ROI**: the **database field, admin setup, user flow, system logic, and math**. I’ll break it down step by step.

---

# **1. ROI Field / Config**

**Field Name:** `weekly_roi_percentage`

**Stored Where:** Admin Settings table (or ROI settings table)

**Type:** Decimal (e.g., 3.5) → represents **percentage per week**

**Purpose:** Admin sets **how much % the user earns weekly** based on their investment.

**Example Value:** `3` → 3% weekly ROI

---

# **2. Admin Side Flow**

1. Admin logs in → goes to **ROI Settings**
2. Admin sees current **weekly ROI %**
3. Admin can **update weekly ROI %** → system stores it in `weekly_roi_percentage`
4. Admin sets only **one value** at a time (system uses this for all users)

**Logic / Validation:**

* Value must be > 0 and < 100
* Optional: Minimum ROI % and Maximum ROI % limits

**Dashboard Display:**

* Current weekly ROI: `3%`
* Weekly ROI applied to all **active investments**

---

# **3. User Side Flow**

### **Step 1: Investment**

* User submits **investment amount**
* Request status = **Pending**

### **Step 2: Admin Approval**

* Admin approves investment
* Investment status = **Active**

### **Step 3: ROI Calculation**

* System calculates **weekly ROI** using the formula:

```text
weekly_roi = deposit_amount * (weekly_roi_percentage / 100)
```

**Example:**

* Deposit = $500
* Weekly ROI = 3% → 500 * 3% = $15 per week

### **Step 4: Wallet Update**

* ROI is **added weekly** to user wallet automatically
* User sees **weekly ROI and cumulative ROI** in dashboard

**Example Dashboard Display:**

| Field            | Value |
| ---------------- | ----- |
| Invested Amount  | $500  |
| Weekly ROI       | $15   |
| Weeks Active     | 3     |
| Total ROI Earned | $45   |
| Wallet Balance   | $45   |

---

# **4. System Logic / Cron Job**

1. Every week, **fetch all active investments**
2. For each active investment:

```text
weekly_roi = deposit_amount * (weekly_roi_percentage / 100)
```

3. Add `weekly_roi` to **user wallet**
4. Record transaction in **ROI history table** for transparency
5. Repeat every week until investment ends (or indefinitely if recurring ROI)

**Optional Config:**

* Max ROI duration (e.g., 12 weeks, 24 weeks, or unlimited)
* Stop ROI if user withdraws principal

---

# **5. Mathematical Example**

* User deposits: $500
* Weekly ROI % = 3%
* System calculates weekly ROI: 500 * 3% = $15

| Week | ROI Earned | Cumulative ROI | Wallet Balance |
| ---- | ---------- | -------------- | -------------- |
| 1    | $15        | $15            | $15            |
| 2    | $15        | $30            | $30            |
| 3    | $15        | $45            | $45            |
| 4    | $15        | $60            | $60            |

* Total monthly ROI = weekly ROI * 4 = $15 * 4 = $60

---

# **6. Summary of Weekly ROI Flow**

```text
Admin sets weekly ROI % → User invests → Admin approves → Investment active → System calculates weekly ROI → ROI added to wallet → User sees weekly + cumulative ROI
```

**Key Points:**

* Only **one pending investment per user**
* ROI calculation is **independent of network**
* Admin can **adjust weekly ROI % anytime**, affecting all new/active investments

---

