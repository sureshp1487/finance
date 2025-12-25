<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R. Arun Kumar - Resume</title>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Calibri', Arial, sans-serif;
            line-height: 1.2;
            color: #000000;
            background-color: #ffffff;
            padding: 0;
            margin: 0;
            font-size: 13pt; /* Increased from 11pt */
        }
        
        /* A4 Page Setup */
        @page {
            size: A4;
            margin: 1cm 1.5cm;
        }
        
        .page {
            width: 21cm;
            height: 29.7cm;
            padding: 1.2cm 1.5cm;
            margin: 0 auto;
            background: white;
            position: relative;
            page-break-after: always;
        }
        
        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: 0.6cm;
            padding-bottom: 0.3cm;
            border-bottom: 3px solid #000000; /* Thicker border */
        }
        
        .name {
            font-size: 28pt; /* Increased from 22pt */
            font-weight: bold;
            margin-bottom: 0.15cm;
            letter-spacing: 0.5px;
        }
        
        .title {
            font-size: 15pt; /* Increased from 12pt */
            font-weight: 600;
            margin-bottom: 0.2cm;
            color: #333;
        }
        
        .contact-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.6cm;
            font-size: 11.5pt; /* Increased from 10pt */
            margin-top: 0.15cm;
        }
        
        /* Section Styles */
        .section {
            margin-bottom: 0.5cm;
        }
        
        .section-title {
            font-size: 14pt; /* Increased from 12pt */
            font-weight: bold;
            margin-bottom: 0.25cm;
            padding-bottom: 0.15cm;
            border-bottom: 2px solid #000000; /* Thicker border */
            text-transform: uppercase;
        }
        
        /* Summary Section */
        .summary-text {
            text-align: justify;
            line-height: 1.35;
            font-size: 12pt; /* Increased from 10.5pt */
        }
        
        /* Skills Section */
        .skills-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.25cm 0.6cm;
        }
        
        .skill-category {
            margin-bottom: 0.15cm;
        }
        
        .skill-category-title {
            font-weight: 600;
            margin-bottom: 0.08cm;
            font-size: 12pt; /* Increased from 10.5pt */
        }
        
        .skill-items {
            line-height: 1.3;
            font-size: 11pt; /* Increased from 10pt */
        }
        
        /* Experience Section */
        .experience-item {
            margin-bottom: 0.35cm;
        }
        
        .job-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.08cm;
        }
        
        .job-title {
            font-weight: 600;
            font-size: 12.5pt; /* Increased from 11pt */
        }
        
        .company {
            font-weight: 600;
            color: #333;
            font-size: 12pt;
        }
        
        .duration {
            font-size: 11pt; /* Increased from 10pt */
            white-space: nowrap;
        }
        
        .responsibilities {
            margin-left: 0.4cm;
        }
        
        .responsibilities li {
            margin-bottom: 0.08cm;
            text-align: justify;
            font-size: 11pt; /* Increased from 10pt */
            line-height: 1.3;
        }
        
        /* Education Section */
        .education-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.25cm;
        }
        
        .education-item {
            margin-bottom: 0.25cm;
        }
        
        .education-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.04cm;
        }
        
        .education-degree {
            font-weight: 600;
            font-size: 11.5pt; /* Increased from 10.5pt */
        }
        
        .education-institution {
            font-size: 11pt; /* Increased from 10pt */
            color: #555;
            margin-bottom: 0.04cm;
        }
        
        .education-details {
            display: flex;
            justify-content: space-between;
            font-size: 10.5pt; /* Increased from 9.5pt */
            color: #666;
        }
        
        /* Certification */
        .certification {
            margin-bottom: 0.15cm;
            font-size: 11pt; /* Increased from 10pt */
        }
        
        /* Strengths */
        .strengths-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.25cm;
        }
        
        .strength-item {
            font-size: 11pt; /* Increased from 10pt */
            margin-bottom: 0.08cm;
        }
        
        .strength-title {
            font-weight: 600;
            color: #333;
        }
        
        /* Declaration */
        .declaration {
            margin-top: 0.6cm;
            padding-top: 0.25cm;
            border-top: 2px solid #000000; /* Thicker border */
            font-size: 10.5pt; /* Increased from 9.5pt */
        }
        
        .declaration-content {
            margin-bottom: 0.25cm;
            text-align: justify;
            line-height: 1.3;
        }
        
        .signature-area {
            display: flex;
            justify-content: space-between;
            margin-top: 0.4cm;
        }
        
        .signature {
            text-align: right;
            font-weight: 600;
            font-size: 11pt;
        }
        
        /* Print Optimization */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
                font-size: 13pt;
            }
            
            .page {
                box-shadow: none;
                margin: 0;
                padding: 1.2cm 1.5cm;
                page-break-after: always;
                width: 21cm;
                height: 29.7cm;
            }
            
            .no-print {
                display: none;
            }
            
            /* Force black and white */
            * {
                color: #000000 !important;
                background-color: #ffffff !important;
            }
        }
        
        /* Action Buttons */
        .print-button {
            text-align: center;
            margin: 0.5cm 0;
            padding: 0.3cm;
            background: #f5f5f5;
        }
        
        .btn-print {
            padding: 0.4cm 0.8cm;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
            font-family: 'Calibri', Arial, sans-serif;
            font-size: 12pt;
            margin: 0.1cm;
            border-radius: 2px;
        }
    </style>
</head>
<body>
    <div class="print-button no-print">
        <button class="btn-print" onclick="window.print()">🖨️ Print Resume</button>
        <button class="btn-print" onclick="saveAsPDF()">💾 Save as PDF</button>
    </div>
    
    <!-- PAGE 1 -->
    <div class="page">
        <!-- Header Section -->
        <header class="header">
            <h1 class="name">R. ARUN KUMAR</h1>
            <div class="title">Laravel Developer | Backend Specialist | API Integration Expert</div>
            
            <div class="contact-info">
                <span>📍 Chennai – 600 087</span>
                <span>📱 7418191487</span>
                <span>✉️ arun199606@gmail.com</span>
                <span>🔗 linkedin.com/in/arun-kumar-laravel-developer/</span>
            </div>
        </header>
        
        <!-- Professional Summary -->
        <section class="section">
            <h2 class="section-title">Professional Summary</h2>
            <p class="summary-text">
                Dedicated Laravel Developer with 2+ years of experience in backend development, API integration, and database-driven applications. 
                Proficient in building scalable CRM and B2B/B2C systems with focus on performance, security, and user experience. 
                Skilled in integrating third-party APIs, GDS/NDC systems, and implementing responsive, mobile-friendly interfaces.
            </p>
        </section>
        
        <!-- Technical Skills -->
        <section class="section">
            <h2 class="section-title">Technical Skills</h2>
            <div class="skills-container">
                <div class="skill-category">
                    <div class="skill-category-title">Programming Languages</div>
                    <div class="skill-items">PHP, JavaScript, HTML5, CSS3</div>
                </div>
                
                <div class="skill-category">
                    <div class="skill-category-title">Frameworks & Libraries</div>
                    <div class="skill-items">Laravel, Bootstrap, jQuery, AJAX</div>
                </div>
                
                <div class="skill-category">
                    <div class="skill-category-title">Tools & Version Control</div>
                    <div class="skill-items">Git, GitHub, Composer, npm</div>
                </div>
                
                <div class="skill-category">
                    <div class="skill-category-title">Databases</div>
                    <div class="skill-items">MySQL, Database Design, Query Optimization</div>
                </div>
                
                <div class="skill-category">
                    <div class="skill-category-title">Architectures & Concepts</div>
                    <div class="skill-items">RESTful APIs, MVC Architecture, OOP, JSON, XML</div>
                </div>
                
                <div class="skill-category">
                    <div class="skill-category-title">Third-Party APIs</div>
                    <div class="skill-items">Twilio, Pabbly, Microsoft Mail, Tawk.to, Net2Phone</div>
                </div>
                
                <div class="skill-category">
                    <div class="skill-category-title">GDS/NDC Flight APIs</div>
                    <div class="skill-items">Sabre, Amadeus, Arajet, Mondee, TrvlNxt, Clarity</div>
                </div>
{{--                 
                <div class="skill-category">
                    <div class="skill-category-title">Development Methodologies</div>
                    <div class="skill-items">Agile, Scrum, Waterfall, Test-Driven Development</div>
                </div> --}}
                
                <div class="skill-category">
                    <div class="skill-category-title">Payment Gateways</div>
                    <div class="skill-items">Razorpay Integration</div>
                </div>
                
                <div class="skill-category">
                    <div class="skill-category-title">Server & Deployment</div>
                    <div class="skill-items">cPanel, Shared Hosting, Basic Linux Commands</div>
                </div>
            </div>
        </section>
        
        <!-- Professional Experience -->
        <section class="section">
            <h2 class="section-title">Professional Experience</h2>
            
            <div class="experience-item">
                <div class="job-header">
                    <div>
                        <span class="job-title">Junior Web Developer</span> | 
                        <span class="company">Vibrace Technologies Pvt. Ltd, Chennai</span>
                    </div>
                    <div class="duration">August 2023 – November 2025</div>
                </div>
                <ul class="responsibilities">
                    <li>Developed and maintained a comprehensive Flight Booking CRM and B2B/B2C Portal using Laravel, MySQL, HTML, CSS, Bootstrap 5, JavaScript, jQuery, and AJAX</li>
                    <li>Designed and integrated RESTful and XML APIs for real-time flight search, booking, PNR management, ticketing, and secure payment gateway integration</li>
                    <li>Integrated multiple GDS & NDC APIs including Sabre, Amadeus, Arajet, Mondee, TrvlNxt, and Clarity to deliver real-time flight availability and dynamic pricing</li>
                    <li>Built scalable CRM modules: Booking Management, Airline Masking & Blocking, Markup & Pricing Engine, Agent & Agency Management, and automated PNR Retrieval</li>
                    <li>Implemented agency-wise SMTP configuration with reusable email templates and automated notification workflows for booking confirmations and updates</li>
                    <li>Developed AJAX-based Email Conversation Management system to track, assign, and manage booking-related communications efficiently</li>
                    <li>Integrated third-party communication APIs including Twilio for SMS, Microsoft Mail System for emails, Pabbly for workflow automation, Tawk.to for live chat, and Net2Phone for telephony support</li>
                    <li>Created responsive, mobile-friendly user interfaces using Bootstrap 5, custom CSS, and AJAX for enhanced user experience across all devices</li>
                  
                    <li>Optimized database queries and implemented caching mechanisms to improve application performance and reduce page load times by 40%</li>
                </ul>
            </div>
        </section>
    </div>
    
    <!-- PAGE 2 -->
    <div class="page">
        <!-- Continued Professional Experience -->
        <div class="experience-item">
            <div class="job-header">
                <div>
                    <span class="job-title">Junior Web Developer (Continued)</span> | 
                    <span class="company">Vibrace Technologies Pvt. Ltd, Chennai</span>
                </div>
                <div class="duration">August 2023 – November 2025</div>
            </div>
            <ul class="responsibilities">
                <li>Developed comprehensive reporting module with data visualization for booking analytics, revenue tracking, and agent performance metrics</li>
                <li>Collaborated with frontend developers and UI/UX designers to ensure seamless integration between backend functionality and user interface</li>
                <li>Performed code reviews, debugging, and troubleshooting to maintain code quality and application stability</li>
                <li>Documented technical specifications, API documentation, and user manuals for system maintenance and future development</li>
            </ul>
        </div>
        
        <div class="experience-item">
            <div class="job-header">
                <div>
                    <span class="job-title">GRN Role (Goods Receipt Note)</span> | 
                    <span class="company">Tata 1mg, Chennai</span>
                </div>
                <div class="duration">November 2021 – February 2023</div>
            </div>
            <ul class="responsibilities">
                <li>Managed Goods Receipt Note (GRN) verification process ensuring 99.8% accuracy in data entry and documentation</li>
                <li>Coordinated workflow between warehouse operations and supply chain management teams for efficient inventory management</li>
            </ul>
        </div>
        
        <!-- Education -->
        <section class="section">
            <h2 class="section-title">Education</h2>
            <div class="education-container">
                <div class="education-item">
                    <div class="education-header">
                        <div class="education-degree">B.E. Agriculture Engineering</div>
                        <div>2018 - 2021</div>
                    </div>
                    <div class="education-institution">Paavai Engineering College (Anna University)</div>
                    <div class="education-details">
                        <div>CGPA: 7.4 / 10.0</div>
                    </div>
                </div>
                
                <div class="education-item">
                    <div class="education-header">
                        <div class="education-degree">Diploma in Agricultural Technology</div>
                        <div>2014 - 2017</div>
                    </div>
                    <div class="education-institution">Sri Sakthi Polytechnic College, Chengam</div>
                    <div class="education-details">
                        <div>Percentage: 87%</div>
                    </div>
                </div>
                
                <div class="education-item">
                    <div class="education-header">
                        <div class="education-degree">Higher Secondary (HSC)</div>
                        <div>2013 - 2014</div>
                    </div>
                    <div class="education-institution">Govt. Hr. Sec. School, Pandeswaram</div>
                    <div class="education-details">
                        <div>Percentage: 75%</div>
                    </div>
                </div>
                
                <div class="education-item">
                    <div class="education-header">
                        <div class="education-degree">Secondary School (SSLC)</div>
                        <div>2011 - 2012</div>
                    </div>
                    <div class="education-institution">Govt. Hr. Sec. School, Pandeswaram</div>
                    <div class="education-details">
                        <div>Percentage: 49%</div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Certification -->
        <section class="section">
            <h2 class="section-title">Certification</h2>
            <div class="certification">
                <div><strong>Web Development</strong> (with IBM Certificate)</div>
                <div>Soft Logic Systems, Chennai | Duration: 6 Months</div>
                <div>Covered: PHP, Laravel, MySQL, JavaScript, HTML5, CSS3, Bootstrap, jQuery, Git</div>
            </div>
        </section>
        
        <!-- Strengths -->
        <section class="section">
            <h2 class="section-title">Personal Strengths</h2>
            <div class="strengths-container">
                <div class="strength-item">
                    <span class="strength-title">Problem Solving:</span> Strong analytical skills with ability to troubleshoot complex technical issues
                </div>
                <div class="strength-item">
                    <span class="strength-title">Technical Aptitude:</span> Quick learner with excellent grasp of new technologies and frameworks
                </div>
                <div class="strength-item">
                    <span class="strength-title">Adaptability:</span> Highly flexible to changing project requirements and technologies
                </div>
                <div class="strength-item">
                    <span class="strength-title">Attention to Detail:</span> Meticulous approach to coding, testing, and documentation
                </div>
            </div>
        </section>
        
        <!-- Declaration -->
        <section class="declaration">
            <div class="declaration-content">
                I hereby declare that the information furnished above is true to the best of my knowledge and belief. I understand that any willful misrepresentation may lead to disqualification or termination of employment.
            </div>
            
            <div class="signature-area">
                <div>
                    <div>Place: Chennai</div>
                    <div>Date: <span id="currentDate1"></span></div>
                </div>
                <div class="signature">
                    (R. ARUN KUMAR)
                </div>
            </div>
        </section>
    </div>
    
    <script>
        // Set current date
        const currentDate = new Date().toLocaleDateString('en-IN', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById('currentDate').textContent = currentDate;
        
        // PDF save function
        function saveAsPDF() {
            alert("To save as PDF:\n1. Click 'Print Resume' button\n2. In print dialog, choose 'Save as PDF' as destination\n3. Set Margins to 'Default' or 'Minimum'\n4. Check 'Background graphics'\n5. Click Save");
            setTimeout(() => window.print(), 100);
        }
        
        // Set document title for PDF
        document.title = "R_Arun_Kumar_Resume";
    </script>
</body>
</html>