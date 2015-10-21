using System;
using System.Collections.Generic;
 
using System.Text;
//using System.Threading.Tasks;
using System.Windows.Forms;

namespace AddTicket
{
    class Program
    {

        static void Main()
        {
            Application.EnableVisualStyles();
            Application.SetCompatibleTextRenderingDefault(false);
            Application.Run(new Form1());
        }
//        static void Main(string[] args)
//        {
////            Jira objJira = new Jira();
////            objJira.JiraUrl = "http://54.154.50.144:8080";
////            objJira.JiraJson = @"{""fields"":{  ""project"":{""key"": ""SM""},
////                                                ""issuetype"": {""name"": ""Task""},
////                                                ""summary"":""ProviderType"",   
////                                                ""priority"":{""name"":""Major""},                                                                                        
////                                                ""duedate"": ""2015-04-23T18:25:43.511Z"",
////                                                ""description"": ""ServiceMappingJiraTest"",
////                                                ""labels"": [""IVRSPregistration""]
////                                                        }}";
////            objJira.JiraUserName="mt2";//"rayanm";
////            objJira.JiraPassword = "tyUrm7oot4d";// "12345678";
////            Console.WriteLine(objJira.addJiraIssue());
////            Console.ReadKey();




//            /*
//             * 
//             * 
//             *   --  ""Priority"":{""value"":""Major""},  
//             *   
//                                                ""Labels"": {""value"":""IVR""}
//             * 
//                                             --   ""Reporter"":""MT2"",
//             * 
//                            objJira.JiraJson = @"{""fields"":{  ""project"":{""key"": ""SM""},
//                                                ""issuetype"": {""name"": ""Task""},
//             *                               -- ""Assignee"":"""",
//                                              --  ""Summary"":{""id"":""name""},
//                                              --  ""Priority"":""High"",                                                
//                                                ""duedate"": ""2015-04-23T18:25:43.511Z"",
//                                             --   ""Reporter"":""MT2"",
//                                                ""description"": ""ServiceMappingJiraTest"",
//                                              --  ""Labels"": ""IVR SP Reistration""
//                                                        }}";
//             * 
//             * 
//             * 
//             * 
//             * 
//             * 
//             * 
//             * */

//        }
    }
}
