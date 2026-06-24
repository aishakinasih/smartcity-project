# smartcity-project

## Team Members

* Syaikha Habibtiana (240025)
* Fitri Sahwalia (240031)
* Aisha Kinasih (240047)

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
