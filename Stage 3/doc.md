# **Technical Document – Mafhoos System**

---

## **User Stories**

### **Vehicle Owner**
- As a user, I create a new user and register my vehicle.  
- As a vehicle’s owner, I book an appointment to check my vehicle, then receive a report.  
- As a vehicle’s owner, I request a spare parts quotation and/or vehicle repair workshops quotation then receive the requested quotations.  

### **Vehicle Inspection Technician**
- As a vehicle inspection technician, I manage booking requests, and approve appointments or rescheduling them.  
- As a vehicle inspection technician, I submit the vehicle check report with suggested spare parts to be replaced.  

### **Spare Parts Supplier**
- As a spare parts supplier, I apply for a registration request for a spare parts supplier account.  
- As a spare parts supplier, I receive spare parts quotation requests and respond with quotations.  

### **Repair Workshop Estimator**
- As a workshop estimator, I apply for a registration request for a workshop account.  
- As a workshop estimator, I receive workshop quotation requests and respond with quotations.  

---

## **Architecture Diagram**
*(To be inserted – represents the system structure and communication flow between components.)*

---

## **Data Flow Diagrams (DFD)**

### **Vehicle Owner**
*(Shows the process of booking, inspection, and receiving reports.)*

### **Inspection Technician**
*(Illustrates the inspection approval and report submission workflow.)*

### **Workshop Repair Estimator**
*(Displays how workshops receive and respond to repair quotations.)*

### **Spare Parts Sales Representative**
*(Shows flow of quotation requests and responses for spare parts.)*

---

## **Entity Relationship Diagram (ERD)**
*(To be inserted – represents relationships between entities such as Users, Vehicles, Appointments, Inspections, Quotations, and Reports.)*

---

## **Sequence Diagram**
*(To be inserted – depicts the interaction between user roles and system components during main processes such as booking, inspection, and quotation.)*

---

## **API Endpoints**

| **Endpoint** | **Request Type** | **Route** |
|---------------|------------------|------------|
| Create Vehicle Owner | GET / POST | `/register` |
| User Login | GET / POST | `/login` |
| Create New Vehicle View | GET | `/vehicles/create` |
| Create and Store New Vehicle | POST | `/vehicles` |
| List Vehicles | GET | `/vehicles` |
| Create Appointments | GET | `/appointments/create` |
| Store Appointments | POST | `/appointments` |
| Create Inspections | POST | `/inspections` |
| List of Inspections | GET | `/inspections` |
| List Quotation Request | GET | `/inspections/{inspection_id}` |
| Create Quotation Request for Repair | POST | `/inspections/{inspection_id}/quotation-requests/repair` |
| Create Quotation Request for Spare Part | POST | `/inspections/{inspection_id}/quotation-requests/spare-part` |
| View Quotation Request and Submit Price | GET / POST | `/quotation-requests/{quotation_requests_id}` |

> **Base Route:** `https://mafhoos.test`

---

## **SCM Processes**

**Version Control Tool:**  
- Git / GitHub

**Branching Strategy:**
