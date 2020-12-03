---
title: "Reproducible analysis of PhenoPlasm data"
author: "Theo Sanderson"
output:
  pdf_document: default
  html_document: default
---
##Domain enrichment
Here we look for InterPro signatures enriched in genes producing Viable and Not-viable mutants.
```{r,warning=FALSE,message=FALSE, tidy.opts=list(width.cutoff=60)}
library(tidyverse)
library(ggsci)
#setwd("C:/Users/Theo/Dropbox/Sanger/PhenoPlasm/R")

data<-read.table("allphenoplasmdata.txt",header=T,sep="\t")
interpro<-read.table("interpro.txt",header=T,sep="\t")
interpro<-unique(interpro[,c("Domain","GeneNew")])

m<-merge(data,interpro,by.x="gene",by.y="GeneNew")
m2<-m
m2$gene=as.character(m$gene)


tab<-table(m$Domain,m$phenotype)
table<-tab[,c("Viable","NotViable")]
sums <- colSums(table)
table=as.data.frame.matrix(table)
table$domain=rownames(table)

table$p1=phyper(table$Viable-1,sums[1],sums[2],table$Viable+table$NotViable,lower.tail=F)
table$p2=phyper(table$NotViable-1,sums[2],sums[1],table$Viable+table$NotViable,lower.tail=F)
MostEnrichedViable<-head(arrange(table,p1))
MostEnrichedNonViable<-tail(arrange(table,-p2))
write.csv(table,"InterProEnrichment.csv")
combo<-bind_rows(MostEnrichedViable,MostEnrichedNonViable)
combo$domain=factor(as.character(combo$domain),levels=as.character(combo$domain))
plottable<-combo %>% select(Viable,NotViable,domain) %>% gather(phenotype,number, Viable, NotViable)

ggplot(plottable,aes(x=domain,fill=phenotype,y=number))+
  geom_bar(stat="identity",position="dodge",width=0.6)+coord_cartesian(ylim=c(0,25))+ theme_bw()+
  scale_fill_npg()+ theme(axis.text.x = element_text(angle = 90,vjust=0.5))+
  labs(x="InterPro signature",y="Number of genes",fill="Phenotype") +
   scale_y_continuous(expand = c(0, 0, 03, 4)) +
  geom_text(data=data.frame(domain="PS51286",number=12,
  label="RAP",phenotype=NA),fill=NA,aes(label=label),color="red")


```

##PubMed
Here we extract from the PubMed database the year associated with all publications associated with phenotypes, and then plot how many phenotypes have been discovered each year.
```{r,warning=FALSE,message=FALSE, tidy.opts=list(width.cutoff=60)}

getDates<- function(subset){
  q<-paste0(paste(subset$Pubmed,sep="", collapse="[uid] OR "),"[uid] ")

res <- EUtilsSummary(unlist(q))

years<-YearPubmed(EUtilsGet(res)) 
ids<-QueryId(res)
pubmeddates <- data.frame(Pubmed=as.integer(as.character(ids)),year=years)
return(pubmeddates)
}
library(RISmed)

csv<-read.csv("PubmedIDAndYear.csv")
pubmed <- csv %>% filter(!is.na(csv$Pubmed))
nonpubmed <- csv %>% filter(is.na(csv$Pubmed))

p1 = getDates(pubmed[1:150,])
p2=  getDates(pubmed[150:372,])

pubmeddates <- bind_rows(p1,p2)

alldata<-full_join(select(csv,Gene,Pubmed),pubmeddates,by="Pubmed")

dfsummarised<- alldata%>% arrange(year) %>% group_by(year) %>% summarise(n=n())
dfsummarised<-dfsummarised%>% mutate(cumsum=cumsum(n))
ggplot(dfsummarised,aes(x=year,y=cumsum))+geom_line(color="#e41a1c")+
  coord_cartesian(xlim=c(2000,2017))+geom_point(color="#e41a1c")+
  theme_bw()+labs(x="Year",y="Available phenotypes")


lm<-lm(cumsum~year,data=dfsummarised)
summary(lm)
lm<-lm(cumsum~year,data=filter(dfsummarised,year>2006))
summary(lm)
```
