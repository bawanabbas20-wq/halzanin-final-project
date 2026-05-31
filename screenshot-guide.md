# Halzanîn — Screenshot Guide for Academic Report

> Prepared by: Claude Code  
> Project: A Digital System for Tracking Public Documents  
> University: Sulaimani Polytechnic University — Technical College of Informatics

---

## ⚠️ Critical Issue to Fix First

Before taking any screenshots, there is a **figure numbering conflict** in the report that must be corrected.

The **List of Figures** (page X) shows:

```
Figure 4.1: Graphical analysis of system resource consumption and processing latency ... 27
```

But **Section 4.4.1** in the body text says:

```
(Figure 4.1: Citizen Service Selection)
```

**Figure 4.1 is used twice with completely different content.** This is a critical formatting error that must be fixed before submission. The correction is detailed below alongside the screenshot list.

---

## Corrected Figure Numbering Table

The performance bar chart keeps its number (Figure 4.1). All 7 interface screenshots shift forward by one.

| Current Label (Wrong) | Correct Label | Description |
|---|---|---|
| Figure 4.1 | **Figure 4.2** | Citizen Service Selection |
| Figure 4.2 | **Figure 4.3** | Session-Persistent Application Form |
| Figure 4.3 | **Figure 4.4** | Digital Application Receipt + QR Code |
| Figure 4.4 | **Figure 4.5** | Halzanîn AI Chatbot Interface |
| Figure 4.5 | **Figure 4.6** | AI Fallback Activation |
| Figure 4.6 | **Figure 4.7** | Ministry-Scoped Staff Dashboard |
| Figure 4.7 | **Figure 4.8** | Dynamic Status Update Interface |

---

## Screenshots — Detailed Instructions

### Figure 4.2 — Citizen Service Selection

**Purpose:** Shows the citizen entering a specific ministry and seeing available services.

**What must be visible:**
- Ministry name and color branding (e.g., Civil Registry navy blue, Traffic Police dark gray)
- At least 2–3 service cards with their names and descriptions
- Apply / Learn More buttons
- Language toggle (EN / کوردی) in the header

**URL target:** `/ministry/civil-registry` or `/ministry/traffic-police`

**Tips:**
- Scroll to show service cards, not just the hero section
- Both languages should be toggled to English for consistency
- Do not show an empty ministry with no services

---

### Figure 4.3 — Session-Persistent Application Form

**Purpose:** Demonstrates the "sticky form" wizard — the core answer to the data persistence problem stated in Chapter 1.

**What must be visible:**
- At least one step of the multi-step form
- Input fields **partially filled** with realistic dummy data (not empty — empty fields do not prove persistence)
- Step indicator if your wizard has one (e.g., Step 2 of 3)
- Required documents checklist if shown on this screen
- Ministry branding color in the header/sidebar

**Tips:**
- Fill in fields like full name, phone number, date of birth with plausible values
- Do not use obviously fake data like "asdfg" or "123"

---

### Figure 4.4 — Digital Application Receipt

**Purpose:** The most important citizen-facing screenshot. Directly proves **Objective 3** (Instant QR Status Tracking).

**What must be visible:**
- The `HZ-XXXXXXXX` tracking code displayed prominently
- The rendered QR code (must be scannable quality)
- Applicant's name and the service name
- Submission date/time
- Download PDF button (if applicable)

**Tips:**
- This screenshot must be pixel-perfect — zoom in slightly on the tracking code + QR area if needed
- Ensure the QR code is not blurry in the screenshot
- If the receipt has a "dark mode" version, use light mode for better print quality

---

### Figure 4.5 — Halzanîn AI Chatbot Interface

**Purpose:** Proves the Mistral AI integration and context-constrained prompt engineering described in Section 2.4.4 and 3.6.

**What must be visible:**
- The chat widget open (not minimized)
- A real user question typed in
- A real AI response that includes specific document requirements from your database
- Recommended question to ask: *"What documents do I need for a driving license?"*
- The AI response should list actual documents (proving it uses your JSON context, not hallucinated data)

**Tips:**
- Do NOT screenshot an empty chat widget
- The response should be long enough to show detail but visible in one frame
- If the chatbot has a typing indicator, wait for the full response before capturing

---

### Figure 4.6 — AI Fallback Activation

**Purpose:** Proves system resilience when the Mistral API is unavailable (described in Section 3.3.1.2).

**Two options to capture this:**

**Option A (most accurate):**
1. Temporarily block the Mistral API call on the server (comment out the HTTP request or set a wrong API key)
2. Ask any question in the chatbot
3. Screenshot the Regex keyword-matched fallback response
4. Restore the original API key immediately after

**Option B (acceptable alternative):**
- If the fallback response has different styling, a different label, or a disclaimer like "Offline mode," screenshot that
- Caption it clearly: *"Figure 4.6: Localized Regex keyword fallback response triggered upon API timeout"*

> **If capturing this is not practical,** you may combine Figures 4.5 and 4.6 into a single side-by-side figure showing English vs. Kurdish responses, and drop the total screenshot count to 7 instead of 8. Update the figure numbering and text accordingly.

---

### Figure 4.7 — Ministry-Scoped Staff Dashboard

**Purpose:** The most important staff-side screenshot. Directly proves **Objective 4** (Strict Ministry Data Isolation) and the Eloquent query scoping described in Section 3.6.2.

**What must be visible:**
- Staff member is logged in — their assigned ministry name must be visible (e.g., "Traffic Police" or "Civil Registry")
- The ministry color branding is visible in the sidebar or header
- The application queue showing ONLY applications for that ministry
- At least 3–5 real application rows with columns: tracking code, applicant name, service, current status, date submitted
- Action buttons (View, Update Status)

**Tips:**
- Log in as a Traffic Police staff member and ensure no Civil Registry applications appear in the queue — this visually proves isolation
- If the queue is empty, create a test application first before taking the screenshot
- The ministry name must be clearly readable — do not crop it out

---

### Figure 4.8 — Dynamic Status Update Interface

**Purpose:** Proves the JSON-based status pipeline described in Section 3.6.3 and Challenge 1 (ENUM to VARCHAR migration) in Section 4.6.1.

**What must be visible:**
- The status-update modal or dropdown open on a specific application
- The dropdown populated with service-specific statuses (not generic ones)
- For a Driving License application, statuses like `theory_test_scheduled` must be visible
- The current status of the application shown
- The application's tracking code visible somewhere on screen

**Tips:**
- This is the screenshot that proves your most technically complex feature — take it carefully
- The key detail is that the dropdown options are DIFFERENT for different services. If possible, include a caption note explaining this.
- Example caption: *"Figure 4.8: Dynamic status update interface showing service-specific pipeline statuses for a Driving License application, driven by the services.statuses JSON column"*

---

## Additional Screenshots (Strongly Recommended)

These are not currently referenced in section 4.4 but would significantly strengthen the report. Add them where indicated.

| Figure | Placement | Why It Helps |
|---|---|---|
| Homepage / Landing Page | Chapter 1 (1.1) or Chapter 3 (3.2) | Establishes visual context for the entire system |
| Login Page (showing the dual-credential input field) | Section 3.6.4 | Directly proves the dual authentication implementation |
| Citizen Dashboard (application history list) | Section 4.4.1 | Completes the full citizen user journey |
| Digital Government ID Card on Profile Page | Section 3.6.4 | Proves the gov\_id system and QR identity card implementation |

If you add these, number them within the chapter they appear in and update the List of Figures accordingly.

---

## Priority Order (If Time Is Limited)

Take these in order — stop when you run out of time:

| Priority | Figure | Reason |
|---|---|---|
| 🥇 1 | Figure 4.4 — Receipt + QR Code | Directly proves core objective 3 |
| 🥈 2 | Figure 4.7 — Staff Dashboard | Directly proves core objective 4 (security) |
| 🥉 3 | Figure 4.3 — Application Form | Directly proves core objective 1 (sticky forms) |
| 4 | Figure 4.5 — AI Chatbot | Proves AI integration |
| 5 | Figure 4.8 — Status Update Dropdown | Proves JSON pipeline (most technical) |
| 6 | Figure 4.2 — Service Selection | Completes citizen journey |
| 7 | Figure 4.6 — AI Fallback | Proves resilience |

---

## Technical Quality Requirements

The dissertation guidelines (page 39) explicitly state:
> *"Figures are high resolution (minimum 300 DPI for printing)"*

Follow these exact steps for every screenshot:

### Chrome / Edge (Recommended Method)

1. Open the page in Chrome or Edge
2. Press `F12` to open DevTools
3. Press `Ctrl + Shift + M` to open the Device Toolbar
4. Set **DPR (Device Pixel Ratio) to 2 or 3** — this doubles/triples the output resolution
5. Set the width to **1440px** for a clean desktop layout
6. Press `Ctrl + Shift + P`
7. Type **"Capture full size screenshot"** and press Enter
8. The PNG file saves automatically — this is lossless, print-quality output

### File Format Rules

| Do | Do Not |
|---|---|
| Save as **PNG** | Save as JPEG (causes compression artifacts on text) |
| Use DevTools full-page capture | Use phone camera pointed at screen |
| Set DPR to 2 or 3 before capture | Resize/upscale images after capture |
| Capture at 1440px+ width | Crop out important UI elements |

---

## Formatting Rules for Inserting Screenshots

Per the dissertation formatting guidelines (pages 41–42):

- **The figure must be centered** on the page
- **The caption must be placed BELOW the figure, also centered**
- Caption font: **Times New Roman, 10pt, Regular**
- Caption format example: `Figure 4.2: Citizen service selection interface showing active services under the Civil Registry ministry`
- After inserting all figures: right-click the List of Figures → **Update Field** → **Update entire table**
- After inserting all figures: right-click the Table of Contents → **Update Field** → **Update entire table**

---

## Text Edits Required in Section 4.4

After fixing the figure numbers, update these specific lines in the report body:

### Section 4.4.1 — Paragraph 1
- Change: `(Figure 4.1: Citizen Service Selection)`
- To: `(Figure 4.2: Citizen Service Selection)`

### Section 4.4.1 — Paragraph 2
- Change: `(Figure 4.2: Session-Persistent Application Form)`
- To: `(Figure 4.3: Session-Persistent Application Form)`
- Change: `(Figure 4.3: Digital Application Receipt)`
- To: `(Figure 4.4: Digital Application Receipt)`

### Section 4.4.2
- Change: `(Figure 4.4: Halzanîn AI Chatbot Interface)`
- To: `(Figure 4.5: Halzanîn AI Chatbot Interface)`
- Change: `(Figure 4.5: AI Fallback Activation)`
- To: `(Figure 4.6: AI Fallback Activation)`

### Section 4.4.3
- Change: `(Figure 4.6: Ministry-Scoped Staff Dashboard)`
- To: `(Figure 4.7: Ministry-Scoped Staff Dashboard)`
- Change: `(Figure 4.7: Dynamic Status Update Interface)`
- To: `(Figure 4.8: Dynamic Status Update Interface)`

---

## Final Checklist Before Submission

Per the dissertation guidelines pre-submission checklist (page 39):

- [ ] Every figure has a caption placed **below** it
- [ ] Every figure is referenced by number in the body text
- [ ] List of Figures updated with correct page numbers for all new figures
- [ ] No figure number is used twice
- [ ] All figures are high resolution (minimum 300 DPI)
- [ ] Figure numbering conflict (Figure 4.1 used twice) is resolved
- [ ] Table of Contents updated after inserting figures (page numbers shift)
- [ ] Captions use Times New Roman 10pt Regular

---

*Document prepared for: Sahand Mhamad, Kara Zahir, Bawan Abbas, Zhyar Kamaran*  
*Supervised by: M. Renas Wrya Mohammed Saeed*  
*May 2026*
