# Contributing Guidelines

## 🧩 Branching Strategy

- `main`: stable production-ready branch
- `<issue-number>-<short-description>`: for new features or fixes  
  Example: `7-establish-git-workflow`

## 🪶 Workflow

1. Pull latest changes
   ```bash
   git checkout dev
   git pull origin dev
    ```
## ✍️ Commit Message Rules

1. Format:
    ```
    <type>: <short description>
    ```
### Types:

1. feat: → new feature
2. fix: → bug fix
3. docs: → documentation
4. style: → formatting
5. refactor: → code restructuring
6. test: → testing
7. chore: → misc updates

#### Example
    feat: add role-based dashboard middleware
    fix: incorrect redirect for landlord after login
    docs: update CONTRIBUTING.md


---

### **3️⃣ Configure Branch Protection Rules (on GitHub)**

Navigate to:  
**Repository → Settings → Branches → Add branch protection rule**

Add for `main`:

✅ **Rules to enable:**
- [x] Require a pull request before merging
- [x] Require approvals (set to at least 1)
- [x] Require branches to be up to date before merging
- [x] Disallow direct pushes
- [x] Require status checks to pass before merging (optional, if using CI)

Then add similar but more flexible rules for `dev` (optional — allow direct merges by maintainers).

---

### **4️⃣ Setup Pull Request Workflow**

When opening PRs:
- Source: `7-issue...`
- Target: `main`
- After QA/testing: PR from `7-issue` → `main` (approved only by admin)

Example PR flow:
```angular2html
7-establish-git-workflow → main
```


---

## ✅ **Acceptance Criteria**

| Criteria | Result                      |
|-----------|-----------------------------|
| Branch rules enforced | ✅ via GitHub branch protection |
| PR workflow functioning | ✅ via issue → main flow     |
| Contributors follow rules | ✅ documented in `CONTRIBUTING.md` |
| Commit messages consistent | ✅ enforced via guidelines   |

---
