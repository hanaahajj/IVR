using System;
using System.Collections.Generic;
 
using System.Text;
using MSXML2;
using Newtonsoft.Json;


using System.Net;
using System.IO;

namespace AddTicket
{
    class Jira
    {
        public String JiraUserName { get; set; }
        public String JiraPassword { get; set; }
        public String JiraUrl { get; set; }
        public String JiraJson { get; set; }
        public XMLHTTP60 JiraService = new XMLHTTP60();

        private const string m_BaseUrl = "http://54.154.50.144:8080/browse/";

        public String addJiraIssue()
        {
            JiraService.open("POST", "http://54.154.50.144:8080" + "/rest/api/2/issue/");
            JiraService.setRequestHeader("Content-Type", "application/json");
            JiraService.setRequestHeader("Accept", "application/json");
            JiraService.setRequestHeader("Authorization", "Basic " + GetEncodedCredentials());
            JiraService.send(JiraJson);
            String response = JiraService.responseText;
            JiraService.abort();
            return response;
        }


        private string GetEncodedCredentials()
        {
            string mergedCredentials = string.Format("{0}:{1}", "rayanm","12345678");
            byte[] byteCredentials = UTF8Encoding.UTF8.GetBytes(mergedCredentials);
            return Convert.ToBase64String(byteCredentials);
        }
    }

    public class JsonResult
    {
        public string id { get; set; }
        public string key { get; set; }
        public string self { get; set; }
    }
 


}
