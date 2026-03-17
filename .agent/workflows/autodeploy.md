---
description: How to manage and monitor a deployment
---

# Deployment Workflow

This workflow guides you through the process of setting up and monitoring your autodeploy system.

## 1. Setup GitHub Secrets

Before the autodeploy can work, you MUST add these secrets to your GitHub repository (Settings > Secrets and variables > Actions):

| Secret Name | Description | Example |
| :--- | :--- | :--- |
| `SSH_HOST` | Your server's IP address or domain | `123.45.67.89` |
| `SSH_USER` | The SSH username | `ubuntu` |
| `SSH_KEY` | Your private SSH key (RSA/PEM) | `-----BEGIN RSA PRIVATE KEY-----...` |
| `DEPLOY_PATH` | Full path to the app on the server | `/var/www/mlm` |

## 2. Triggering a Deploy

// turbo
Every time you push to the `main` branch, the deployment will start automatically.

## 3. Verify Deployment Status

You can check the status of your deployment in the "Actions" tab of your GitHub repository.

## 4. Manual Deployment Commands

If you need to deploy manually from this terminal, you can run:

```powershell
# This is a placeholder for any manual deployment scripts you might have
# e.g., git push origin main
```
