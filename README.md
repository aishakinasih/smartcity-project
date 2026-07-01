# smartcity-project

## Team Members

* Syaikha Habibtiana (140810240025)
* Fitri Sahwalia (140810240031)
* Aisha Kinasih (140810240047)

# Reporta: AI-Based Public Report Urgency Prioritization System

Reporta is a smart governance platform that transforms the public complaint handling mechanism. The system is designed to address inefficiencies in traditional public service methods that generally rely on a First-In, First-Out (FIFO) queue system, which often fails to respond quickly to emergency cases.

## Dataset

The model training dataset was obtained through a scraping process from LAPOR! (Layanan Aspirasi dan Pengaduan Online Rakyat), the official public complaint platform of the Indonesian government.

* Number of data records: 370 reports
* Source: LAPOR! Website (lapor.go.id)
* Category labels: Urgency — High, Medium, Low
* Labeling method: Manual labeling by the team
* Data split: 70% training, 20% testing, 10% validation
* Preprocessing: Tokenization, stopword removal, Indonesian text normalization

## Operational Concept and System Philosophy

* Workflow Transformation: Replaces slow manual systems with intelligent automation to ensure that emergency reports receive top priority and immediate response.
* AI-Based Classification: Integrates the IndoBERT model as the core intelligence of the system to perform Natural Language Processing (NLP) for accurately categorizing report topics and urgency levels.
* Confidence Filtering Mechanism: The system balances efficiency and accuracy. Reports with prediction confidence levels above 80% are automatically directed to the handling dashboard, while reports below the threshold undergo manual review to ensure response accuracy.

### Ethical Responsibility

The system is designed as a decision support tool. Final responsibility for field actions remains with authorized personnel to maintain transparency and fairness.

## Technical Specifications and Performance

* Model Accuracy: The IndoBERT model has been optimized to achieve 92% accuracy in classifying various types of public reports.
* Evaluation Reliability: System testing demonstrates solid performance metrics with an average accuracy of 92%, Precision of 91%, Recall of 
  93%, and F1-Score of 92%.
* Core Technologies: A combination of the Laravel framework for backend management, MySQL database, and Python-based AI processing in the 
  Google Colab environment.

## System Architecture

The system adopts a structured workflow consisting of:

1. Report Input: Collection of public reports through the system.
2. Text Preprocessing: Cleaning and preparation of textual data.
3. Urgency Classification: Classification of report urgency levels by the IndoBERT model into High, Medium, or Low categories.
4. Distribution: Routing reports to a visual dashboard for human oversight and follow-up actions by officers.

## Benefits

1. Responsiveness
   Reduces waiting time in handling critical situations such as natural disasters, fires, or threats to public safety.
2. Operational Optimization
   Reduces the manual workload of agency personnel in categorizing thousands of incoming reports daily.
3. Service Scalability
   Helps city agencies manage large volumes of public complaints without compromising service quality for citizens.

## Project Access

Website & GitHub: https://linktr.ee/ReportaAI

Model: https://drive.google.com/drive/folders/1nyMKRV1oQBMF-HMPGKs8FDqHN5ytD_Dp?usp=drive_link

## How to Use

### 1. Public User (Citizen)

1. Open the Reporta website.
2. Register a new account.
3. Log in using the registered account.
4. Submit a public report by filling in:
   - Government agency (Instansi)
   - Report title
   - Report description
   - Location
   - Supporting photo (optional)
5. After submission, the report will be automatically analyzed by the AI model.
6. Users can monitor the report status through the **Report History** page.

### 2. Administrator (AI Result)

The AI prediction results are displayed on the administrator dashboard after a report has been submitted.

Two administrator roles are available:

#### Super Administrator

Has access to:
- View all reports from every agency.
- View AI urgency prediction (High / Medium / Low).
- View AI confidence score.
- Monitor report statistics.
- Update report status.

Login credentials:

Email:
```
superadmin@smartcity.go.id
```

Password:
```
password123

```

#### Agency Administrator

Agency Administrator accounts are available for each participating government agency.  
Use the following login format:

**Email**
```
admin1@smartcity.go.id
admin2@smartcity.go.id
...
admin13@smartcity.go.id
```

**Password (all accounts)**
```
password123
```

The administrator accounts correspond to the following government agencies:

| Email | Government Agency |
|--------|-------------------|
| admin1@smartcity.go.id | DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN |
| admin2@smartcity.go.id | DINAS SOSIAL |
| admin3@smartcity.go.id | DINAS PERHUBUNGAN |
| admin4@smartcity.go.id | SEKRETARIAT DAERAH |
| admin5@smartcity.go.id | SEKRETARIAT DPRD |
| admin6@smartcity.go.id | DINAS PENDIDIKAN |
| admin7@smartcity.go.id | SATUAN POLISI PAMONG PRAJA |
| admin8@smartcity.go.id | DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL |
| admin9@smartcity.go.id | DINAS KESEHATAN |
| admin10@smartcity.go.id | BADAN PENANGGULANGAN BENCANA DAERAH (BPBD) |
| admin11@smartcity.go.id | DINAS PERUMAHAN, KAWASAN PERMUKIMAN DAN PERTANAHAN |
| admin12@smartcity.go.id | DINAS TENAGA KERJA DAN TRANSMIGRASI |
| admin13@smartcity.go.id | DINAS LINGKUNGAN HIDUP DAN KEHUTANAN |

## AI Workflow

1. Citizen submits a report.
2. Laravel sends the report text to the AI API.
3. The IndoBERT model predicts the urgency level.
4. The prediction result and confidence score are stored in the database.
5. Administrators can immediately view the prediction on the dashboard and prioritize urgent reports.

---

## Notes

- New users should create their own account through the registration page.
- AI prediction is generated automatically after a report is submitted.
- The urgency prediction and confidence score are visible only to administrators.
- Final decision-making remains under the responsibility of the authorized government officer.
