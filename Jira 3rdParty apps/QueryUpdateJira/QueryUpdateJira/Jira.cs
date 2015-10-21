using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using Newtonsoft.Json;


using MSXML2;
using System.Net;
using System.IO;


namespace QueryUpdateJira
{
    class Jira
    {
        public String JiraUserName { get; set; }
        public String JiraPassword { get; set; }
        public String JiraUrl { get; set; }
        public String JiraJson { get; set; }
        public XMLHTTP60 JiraService = new XMLHTTP60();

        private const string m_BaseUrl = "http://54.154.50.144:8080/browse/";

    

      
        public String editJiraIssue()
        {
            JiraService.open("PUT", "http://54.154.50.144:8080/rest/api/2/issue/SM-1026");
            JiraService.setRequestHeader("Content-Type", "application/json");
            JiraService.setRequestHeader("Accept", "application/json");
            JiraService.setRequestHeader("Authorization", "Basic " + GetEncodedCredentials());
           
            //JiraService.send(JiraJson);
            String response = JiraService.responseText;
            JiraService.abort();
            return response;
        }

        //public void SetJiraIssue(string issueKey, Jira j)
        //{
        //    RestRequest request = new RestRequest("issue/{key}", Method.PUT);
        //    request.AddUrlSegment("key", issueKey);
        //    request.RequestFormat = DataFormat.Json;

        //    string jSonContent = @"{""fields"":{""summary"":""test 123""}}";
        //    request.AddParameter("application/json", jSonContent, ParameterType.RequestBody);

        //    //   var response = Execute(request);

        //    var client = new RestClient("http://54.154.50.144:8080/rest/api/2/issue/SM-1029/");
        //    client.Authenticator = new HttpBasicAuthenticator("mt2", "tyUrm7oot4d");
        //    //  request.AddParameter("AccountSid", _accountId, ParameterType.UrlSegment);
        //    var response = client.Execute(request);

        //    if (response.ErrorException != null)
        //    {
        //        const string message = "Error retrieving response.  Check inner details for more info.";
        //        var jiraManagerException = new ApplicationException(message, response.ErrorException);
        //        throw jiraManagerException;
        //    }
        //    //   var responses = response.;
        //    Console.WriteLine(response);
        //}

        private string GetEncodedCredentials()
        {
            string mergedCredentials = string.Format("{0}:{1}", "rayanm","12345678");
            byte[] byteCredentials = UTF8Encoding.UTF8.GetBytes(mergedCredentials);
            return Convert.ToBase64String(byteCredentials);
        }
    }
}
