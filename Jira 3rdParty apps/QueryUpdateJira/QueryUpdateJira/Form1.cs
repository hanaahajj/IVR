using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;

using System.Text; 
using System.Windows.Forms;

namespace QueryUpdateJira
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

            QueryData();
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
                button1.Text = "Stop";
                QueryData();
                Timer.Interval = (int)numericUpDown1.Value;
                Timer.Enabled = true;
                
            }

        }


        public void QueryData()
        {
            string szSummary = "", szKey="";
            string username = "mt2";
            string password = "tyUrm7oot4d";
            JiraManager manager = new JiraManager(username, password);
           

            string jql = "project = " + "SM AND issuetype = Task AND assignee in (mt2)"; 
            //string jql = "project = " + projectKey;
            List<Issue> issueDescriptions = manager.GetIssues(jql);
            if (issueDescriptions.Count > 0)
            {
                foreach (Issue description in issueDescriptions)
                {
                    LogData(description.Key + " --- " + description.Fields.Summary);
                    string szt = description.Fields.Description;

                    szKey = description.Key.ToString();
                    szSummary = description.Fields.Summary;
                    if (szSummary == "Service Provider Ticket")
                    {
                        DSTableAdapters.spjiracreationTableAdapter _ad = new DSTableAdapters.spjiracreationTableAdapter();
                        _ad.UpdateSPJiraCreation(szKey);

                    }
                    else if (szSummary == "Focal Point Ticket")
                    {
                        DSTableAdapters.focalpointjiracreationTableAdapter _ad = new DSTableAdapters.focalpointjiracreationTableAdapter();
                        _ad.UpdateFocalPointJiraCreation(szKey);

                    }
                    else if (szSummary == "Service Ticket")
                    {
                        DSTableAdapters.servicejiracreationTableAdapter _ad = new DSTableAdapters.servicejiracreationTableAdapter();
                        _ad.UpdateServiceJiraCreation(szKey);

                    }
                    else if (szSummary == "Feedback IVR")
                    {
                    }
                    EditSPTicket(description.Key.ToString());
                }
            }
            else
            {
                LogData("No Data");
            }

        }

        public void EditSPTicket(string szKey)
        {
            //string jql = @"{ ""update"": { ""labels"": [ {""add"": ""testlabel""} ] } }";
            string jql = @"{ ""update"": { ""assignee"" : [{""set"" : {""name"" : ""omarm""}}]}}";
            string username = "mt2";
            string password = "tyUrm7oot4d";
            JiraManager manager = new JiraManager(username, password);

            string url = "http://54.154.50.144:8080/rest/api/2/issue/" + szKey;

            string g = manager.Update(jql, url);


            LogData("Updated Tiket with Key: " + szKey);
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
