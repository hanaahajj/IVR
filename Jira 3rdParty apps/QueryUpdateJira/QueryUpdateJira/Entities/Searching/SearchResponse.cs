using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using Newtonsoft.Json;
using QueryUpdateJira.Entities.Issues;

namespace QueryUpdateJira.Entities.Searching
{
    /// <summary>
    /// A class representing a JIRA REST search response
    /// </summary>
    public class SearchResponse
    {
        [JsonProperty("expand")]
        public string Expand { get; set; }

        [JsonProperty("startAt")]
        public int StartAt { get; set; }

        [JsonProperty("maxResults")]
        public int MaxResults { get; set; }

        [JsonProperty("total")]
        public int Total { get; set; }

        [JsonProperty("issues")]
        public List<Issue> IssueDescriptions { get; set; }
    }
}
