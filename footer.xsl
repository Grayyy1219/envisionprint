<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes"/>
    
    <xsl:template match="/footer">

            <div class="companyname">
                <h1><xsl:value-of select="companyname"/></h1> <!-- XPath -->
            </div>

            <div class="flinks">
                <xsl:for-each select="flinks/link"> <!-- XPath -->
                    <a href="{@href}">
                        <p><xsl:value-of select="text"/></p>
                    </a>
                </xsl:for-each>
            </div>

            <ul class="fsocials">
                 <xsl:for-each select="fsocials/social"> <!-- XPath -->
                    <li class="ftco-animate">
                        <a href="{url}" target="_blank">
                            <img src="{img/@src}" alt="{image/@alt}" width="{img/@width}"/>
                        </a>
                    </li>
                </xsl:for-each>
            </ul>

            <div>
                <p><xsl:value-of select="copyright/text"/></p><!-- XPath -->
            </div>

    </xsl:template>
</xsl:stylesheet>
