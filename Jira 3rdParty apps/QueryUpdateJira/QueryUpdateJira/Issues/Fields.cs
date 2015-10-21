using System;
using System.Collections.Generic;

using System.Text;
using Newtonsoft.Json;

namespace QueryUpdateJira
{
    /// <summary>
    /// Represents a Fields JSON object
    /// </summary>
    /// <remarks>
    /// "fields" : {
    ///	    "summary" : "Some summary",
    ///	    "status" : {
    ///	    	...
    ///	    },
    ///	    "assignee" : {
    ///	    	...
    ///	    }
    /// }    
    /// </remarks>
    public class Fields
    {
        [JsonProperty("summary")]
        public string Summary { get; set; }

        [JsonProperty("description")]
        public string Description { get; set; }


        [JsonProperty("status")] 
        public Status Status { get; set; }

        [JsonProperty("assignee")]
        public Assignee Assignee { get; set; }
    }
}
