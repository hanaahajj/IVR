using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
 
using System.Text;
using System.Windows.Forms;
using Newtonsoft.Json;

using System.Web;
using System.IO;
using System.Net;


namespace AddTicket
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
            button1.Text = "Start";
            Timer.Enabled = false;
            Timer.Interval = (int)numericUpDown1.Value;
            
        }

        private void Timer_Tick(object sender, EventArgs e)
        {
           
            GetData();
        }


        private void button1_Click(object sender, EventArgs e)
        {
            if (Timer.Enabled)
            {
                Timer.Enabled = false;
                button1.Text = "Start";
            }
            else
            {
                //GetFeedbackData();
                GetData();
                Timer.Interval = (int)numericUpDown1.Value;
                Timer.Enabled = true;
                button1.Text = "Stop";
            }

        }

        private void GetData()
        {
            Timer.Enabled = false;
            GetSPData();
            GetFocalPointData();
            GetServiceData();
            GetFeedbackData();
            Timer.Enabled = true;
        }


        //Create Feedback Ticket
        private void GetFeedbackData()
        {
            try
            {
                DS.feedbackjiracreationDataTable _dt = new DS.feedbackjiracreationDataTable();
                DSTableAdapters.feedbackjiracreationTableAdapter _ad = new DSTableAdapters.feedbackjiracreationTableAdapter();

                _dt = _ad.GetDataFeedbackJiraCreation();
                

                if (_dt != null)
                {
                    if (_dt.Rows.Count > 0)
                    {
                        string szId = _dt.Rows[0]["id"].ToString();
                        for (int i = 0; i < _dt.Rows.Count; i++)
                        {
                            createFeedbackTicket(_dt, i);
                        }
                    }
                    else
                    {
                        LogData("No Data for Feedback");
                    }
                }
            }
            catch (Exception ex)
            {
                LogData("Exception:" + ex.ToString());
            }
        }
        public void createFeedbackTicket(DS.feedbackjiracreationDataTable _dt, int index)
        {

            string szPath = _dt.Rows[index]["RefugeeNamePath"].ToString().Replace(@"\", @"\\");
            Jira objJira = new Jira();
            objJira.JiraUrl = "http://54.154.50.144:8080";
            objJira.JiraJson = @"{""fields"":{  ""project"":{""key"": ""LBF""},
                                                ""issuetype"": {""name"": ""Task""},
                                                ""summary"":""Feedback IVR"",   
                                                ""priority"":{""name"":""Minor""},                                                                                        
                                                ""duedate"": """ + DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") + @""",
                                                ""description"": """", 
                                                ""customfield_11844"":""" + szPath + @""",  
                                                ""customfield_11845"":""" + _dt.Rows[index]["NationalityId"].ToString() + @""",        
                                                ""customfield_11846"":" + _dt.Rows[index]["Age"].ToString() + @",          
                                                ""customfield_11847"":""" + _dt.Rows[index]["ServiceType"].ToString() + @""",  
                                                ""customfield_11848"":""" + _dt.Rows[index]["ServiceGov"].ToString() + @""" ,
                                                ""customfield_11849"":""" + _dt.Rows[index]["ServiceDist"].ToString() + @""" ,    
                                                ""customfield_11850"":""" + _dt.Rows[index]["SPId"].ToString() + @""" ,     
                                                ""customfield_11851"":""" + _dt.Rows[index]["ServiceId"].ToString() + @""" ,  
                                                ""customfield_11852"":" + _dt.Rows[index]["IsAnonymous"].ToString() + @",    
                                                ""customfield_11853"":" + _dt.Rows[index]["Answer1"].ToString() + @",       
                                                ""customfield_11854"":" + _dt.Rows[index]["Answer2"].ToString() + @",   
                                                ""customfield_11855"":" + _dt.Rows[index]["Answer3"].ToString() + @",      
                                                ""customfield_11856"":" + _dt.Rows[index]["Answer4"].ToString() + @",    
                                                ""customfield_11857"":" + _dt.Rows[index]["Answer5"].ToString() + @",
                                                ""customfield_11858"":" + _dt.Rows[index]["Answer6"].ToString() + @",   
                                                ""customfield_11859"":" + _dt.Rows[index]["Answer7"].ToString() + @", 
                                                ""customfield_11860"":""" + _dt.Rows[index]["ExtraExplanation"].ToString() + @""" ,  
                                                ""customfield_11861"":""" + _dt.Rows[index]["ExtraComments"].ToString() + @""" ,                                      
                                                ""labels"": [""IVRFeedback""]

                                                        }}";

            /*
             * 
             *     ""customfield_11844"":"""",   NAme Path 
                   ""customfield_11845"":""9"",      Nationality 
                    ""customfield_11846"":27,    Age 
                    ""customfield_11847"":""2"",    Type 
                    ""customfield_11848"":""2"",    Gov 
                    ""customfield_11849"":""2"",    District 
                    ""customfield_11850"":""2"",    SP 
                    ""customfield_11851"":""2"",    ServiceId 
                    ""customfield_11852"":1,     Anonymous
                    ""customfield_11853"":1,     Answer 1 
                    ""customfield_11854"":2,     Answer2
                    ""customfield_11855"":3,     Answer3
                    ""customfield_11856"":4,     Answer4
                    ""customfield_11857"":5,    Answer5
                    ""customfield_11858"":6,    Answer6
                    ""customfield_11859"":7,    Answer7
                    ""customfield_11860"":""2"",    Additional Explanation
                    ""customfield_11861"":""2"", ExtraComments
             * 
             * 
             */
            objJira.JiraUserName = "mt2";
            objJira.JiraPassword = "tyUrm7oot4d";
            string szJsonResponse = objJira.addJiraIssue();

            JsonResult data = JsonConvert.DeserializeObject<JsonResult>(szJsonResponse);
            string szKey = data.key.ToString();
            DSTableAdapters.feedbackjiracreationTableAdapter _ad = new DSTableAdapters.feedbackjiracreationTableAdapter();
            _ad.UpdateFeedbackJiraCreation(szKey, Convert.ToInt16(_dt.Rows[0]["id"].ToString()));


            LogData("Created Jira Feedback Ticket with key: " + szKey);

        }


        //Create SP Ticket
        private void GetSPData()
        {
            try
            {
                DS.spjiracreationDataTable _dt = new DS.spjiracreationDataTable();
                DSTableAdapters.spjiracreationTableAdapter _ad = new DSTableAdapters.spjiracreationTableAdapter();

                _dt = _ad.GetSPJiraCreationData();

                if (_dt != null)
                {
                    if (_dt.Rows.Count > 0)
                    {
                        string szId = _dt.Rows[0]["id"].ToString();
                        for (int i = 0; i < _dt.Rows.Count; i++)
                        {
                            createSPTicket(_dt, i);
                        }
                    }
                    else
                    {
                        LogData("No Data for SP");
                    }
                }
            }
            catch (Exception ex)
            {
                LogData("Exception:" + ex.ToString());
            }
        }
        public void createSPTicket(DS.spjiracreationDataTable _dt, int index)
        {
            string szPath = _dt.Rows[index]["Links"].ToString().Replace(@"\", @"\\");

            Jira objJira = new Jira();
            objJira.JiraUrl = "http://54.154.50.144:8080";
            //            objJira.JiraJson = @"{""fields"":{""project"":{""key"": ""SM""},""summary"": ""JiraTestMT2- 1.2"",""description"": ""ServiceMappingJiraTest- 1.2"",""issuetype"": {""name"": ""Task""},""duedate"": ""2015-04-23T18:25:43.511Z""}}";
            //""summary"":""ProviderType : """ + _dt.Rows[index]["spType"].ToString() + @""",
            objJira.JiraJson = @"{""fields"":{  ""project"":{""key"": ""SM""},
                                                ""issuetype"": {""name"": ""Task""},
                                                ""summary"":""Service Provider Ticket"",
                                                ""priority"":{""name"":""Major""},                                                                                        
                                                ""duedate"": """ + DateTime.Now.AddDays(5).ToString("yyyy-MM-dd HH:mm:ss") + @""",
                                                ""description"":  """ + szPath + @""",
                                                ""labels"": [""" + _dt.Rows[index]["JiraLabel"].ToString() + @"""]
                                                        }}";
            objJira.JiraUserName = "mt2";//"rayanm";
            objJira.JiraPassword = "tyUrm7oot4d";// "12345678";
            string szJsonResponse = objJira.addJiraIssue();





            JsonResult data = JsonConvert.DeserializeObject<JsonResult>(szJsonResponse);
            string szKey = data.key.ToString();
            DSTableAdapters.spjiracreationTableAdapter _ad = new DSTableAdapters.spjiracreationTableAdapter();
            _ad.UpdateSPJiraCreation(szKey, Convert.ToInt16(_dt.Rows[0]["id"].ToString()));


            LogData("Created Jira SP Ticket with key: " + szKey);




        }


        //Create FocalPoint Ticket
        private void GetFocalPointData()
        {
            try
            {
                DS.focalpointjiracreationDataTable _dt = new DS.focalpointjiracreationDataTable();
                DSTableAdapters.focalpointjiracreationTableAdapter _ad = new DSTableAdapters.focalpointjiracreationTableAdapter();

                _dt = _ad.GetFocalPointJiraCreationData();
                if (_dt != null)
                {
                    if (_dt.Rows.Count > 0)
                    {
                        string szId = _dt.Rows[0]["id"].ToString();
                        for (int i = 0; i < _dt.Rows.Count; i++)
                        {
                            createFocalPointTicket(_dt, i);
                        }
                    }
                    else
                    {
                        LogData("No Data for FocalPoint Update");
                    }
                }
            }
            catch (Exception ex)
            {
                LogData("Exception:" + ex.ToString());
            }
        }
        public void createFocalPointTicket(DS.focalpointjiracreationDataTable _dt, int index)
        {
            string szPath = _dt.Rows[index]["Links"].ToString().Replace(@"\", @"\\");
            Jira objJira = new Jira();
            objJira.JiraUrl = "http://54.154.50.144:8080";
            objJira.JiraJson = @"{""fields"":{  ""project"":{""key"": ""SM""},
                                                ""issuetype"": {""name"": ""Task""},
                                                ""summary"":""Focal Point Ticket"",   
                                                ""priority"":{""name"":""Major""},                                                                                        
                                                ""duedate"": """ + DateTime.Now.AddDays(5).ToString("yyyy-MM-dd HH:mm:ss") + @""",
                                                ""description"":  """ + szPath + @""",
                                                ""labels"": [""" + _dt.Rows[index]["JiraLabel"].ToString() + @"""]
                                                        }}";
            objJira.JiraUserName = "mt2";//"rayanm";
            objJira.JiraPassword = "tyUrm7oot4d";// "12345678";
            string szJsonResponse = objJira.addJiraIssue();




            JsonResult data = JsonConvert.DeserializeObject<JsonResult>(szJsonResponse);
            string szKey = data.key.ToString();
            DSTableAdapters.focalpointjiracreationTableAdapter _ad = new DSTableAdapters.focalpointjiracreationTableAdapter();
            _ad.UpdateFocalPointJiraCreation(szKey, Convert.ToInt16(_dt.Rows[index]["id"].ToString()));

            LogData("Created Jira FocalPoint Ticket with key: " + szKey);



        }


        //Create Service Ticket
        private void GetServiceData()
        {
            try
            {
                DS.servicejiracreationDataTable _dt = new DS.servicejiracreationDataTable();
                DSTableAdapters.servicejiracreationTableAdapter _ad = new DSTableAdapters.servicejiracreationTableAdapter();

                _dt = _ad.GetServiceJiraCreationData();
                if (_dt != null)
                {
                    if (_dt.Rows.Count > 0)
                    {
                        string szId = _dt.Rows[0]["id"].ToString();
                        for (int i = 0; i < _dt.Rows.Count; i++)
                        {
                            createServiceTicket(_dt,i);
                        }
                    }
                    else
                    {
                        LogData("No Data for Service");
                    }
                }
            }
            catch (Exception ex)
            {
                LogData("Exception:" + ex.ToString());
            }
        }
        public void createServiceTicket(DS.servicejiracreationDataTable _dt, int index)
        {
            string szPath = _dt.Rows[index]["Links"].ToString().Replace(@"\", @"\\");
            Jira objJira = new Jira();
            objJira.JiraUrl = "http://54.154.50.144:8080";
            objJira.JiraJson = @"{""fields"":{  ""project"":{""key"": ""SM""},
                                                ""issuetype"": {""name"": ""Task""},
                                                ""summary"":""Service Ticket"",   
                                                ""priority"":{""name"":""Major""},                                                                                        
                                                ""duedate"": """ + DateTime.Now.AddDays(5).ToString("yyyy-MM-dd HH:mm:ss") + @""",
                                                ""description"":  """ + szPath + @""",
                                                ""labels"": [""" + _dt.Rows[index]["JiraLabel"].ToString() + @"""]
                                                        }}";
            objJira.JiraUserName = "mt2";//"rayanm";
            objJira.JiraPassword = "tyUrm7oot4d";// "12345678";
            string szJsonResponse = objJira.addJiraIssue();

            JsonResult data = JsonConvert.DeserializeObject<JsonResult>(szJsonResponse);
            string szKey = data.key.ToString();
            DSTableAdapters.servicejiracreationTableAdapter _ad = new DSTableAdapters.servicejiracreationTableAdapter();
            _ad.UpdateServiceJiraCreation(szKey, Convert.ToInt16(_dt.Rows[index]["id"].ToString()));


            LogData("Created Jira Service Ticket with key: "+ szKey);



        }
        
        
        
        public void LogData(string vMessage)
        {
            vMessage = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss") + " --- " + vMessage;
            try
            {
                if (listBox1.Items.Count > 100)
                    listBox1.Items.RemoveAt(listBox1.Items.Count - 1);


                listBox1.Items.Insert(0, vMessage);
                listBox1.SelectedIndex = 0;
            }
            catch (Exception ex)
            {
                LogData(ex.ToString());
            }


        }

 
      


       

    }
}
